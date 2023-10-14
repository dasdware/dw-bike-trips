import 'dart:async';

import 'package:dw_bike_trips_client/queries.dart';
import 'package:dw_bike_trips_client/session/operations.dart';
import 'package:dw_bike_trips_client/session/operations/dashboard_operation.dart';
import 'package:dw_bike_trips_client/session/operations/timestamp.dart';
import 'package:graphql_flutter/graphql_flutter.dart';

class DashboardDistances {
  final double today;
  final double yesterday;
  final double thisWeek;
  final double lastWeek;
  final double thisMonth;
  final double lastMonth;
  final double thisYear;
  final double lastYear;
  final double allTime;

  DashboardDistances(
      {required this.today,
      required this.yesterday,
      required this.thisWeek,
      required this.lastWeek,
      required this.thisMonth,
      required this.lastMonth,
      required this.thisYear,
      required this.lastYear,
      required this.allTime});

  DashboardDistances.zero()
      : today = 0,
        yesterday = 0,
        thisWeek = 0,
        lastWeek = 0,
        thisMonth = 0,
        lastMonth = 0,
        thisYear = 0,
        lastYear = 0,
        allTime = 0;
}

class DashboardHistoryEntry {
  final int group;
  final int item;
  final int count;
  final double distance;

  DashboardHistoryEntry(this.group, this.item, this.count, this.distance);
}

class Dashboard {
  final DashboardDistances distances;
  final List<DashboardHistoryEntry> history;

  Dashboard({
    required this.distances,
    required this.history,
  });

  Dashboard.zero()
      : distances = DashboardDistances.zero(),
        history = Iterable<int>.generate(12).map(
          (i) {
            var now = Timestamp.now();
            return DashboardHistoryEntry(
                now.year, (now.month - i) % 12, 0, 0.0);
          },
        ).toList();
}

class DashboardController {
  final String pageName;
  final OperationContext context;
  final GraphQLClient client;

  AccumulationKind _accumulationKind = AccumulationKind.months;

  Dashboard? _dashboard;
  final StreamController<Dashboard> _streamController =
      StreamController<Dashboard>.broadcast();

  Dashboard get dashboard {
    if (_dashboard == null) {
      _dashboard = Dashboard.zero();
      _update();
    }
    return _dashboard!;
  }

  get stream => _streamController.stream;

  DashboardController(this.pageName, this.context, this.client);

  void dispose() {
    _streamController.close();
  }

  AccumulationKind get accumulationKind => _accumulationKind;

  set accumulationKind(AccumulationKind kind) {
    _accumulationKind = kind;
    _update();
  }

  _update() async {
    var result = await context.perform(
      pageName,
      DashboardOperation(client, accumulationKind),
    );

    if (result.success) {
      _dashboard = result.value;
      _streamController.sink.add(_dashboard!);
    }
  }

  invalidate() {
    _dashboard = null;
  }

  refresh() {
    invalidate();
    _update();
  }
}
