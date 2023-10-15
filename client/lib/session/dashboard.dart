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

  Dashboard withSum() {
    List<DashboardHistoryEntry> summedHistory = [];
    var sum = 0.0;
    for (final entry in history) {
      sum += entry.distance;
    }

    for (final entry in history) {
      summedHistory.add(
          DashboardHistoryEntry(entry.group, entry.item, entry.count, sum));
      sum -= entry.distance;
    }

    return Dashboard(distances: distances, history: summedHistory);
  }
}

class DashboardController {
  final String pageName;
  final OperationContext context;
  final GraphQLClient client;

  AccumulationKind? _lastAccumulationKind;
  Dashboard? _originalDashboard;

  AccumulationKind _accumulationKind = AccumulationKind.months;
  bool _sum = false;

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

  bool get sum => _sum;

  set sum(bool sum) {
    if (_sum != sum) {
      _sum = sum;
      _update();
    }
  }

  _update() async {
    if (_lastAccumulationKind != _accumulationKind) {
      var result = await context.perform(
        pageName,
        DashboardOperation(client, accumulationKind),
      );

      if (!result.success) {
        return;
      }

      _originalDashboard = result.value;
      _lastAccumulationKind = _accumulationKind;
    }

    if (_sum) {
      _dashboard = _originalDashboard?.withSum();
    } else {
      _dashboard = _originalDashboard;
    }

    _streamController.sink.add(_dashboard!);
  }

  invalidate() {
    _dashboard = null;
  }

  refresh() {
    invalidate();
    _update();
  }
}
