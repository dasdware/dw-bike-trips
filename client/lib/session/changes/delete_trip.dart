import 'package:dw_bike_trips_client/session/changes_queue.dart';
import 'package:dw_bike_trips_client/session/dashboard.dart';
import 'package:dw_bike_trips_client/session/operations.dart';
import 'package:dw_bike_trips_client/session/operations/delete_trips_operation.dart';
import 'package:dw_bike_trips_client/session/session.dart';
import 'package:dw_bike_trips_client/session/trip.dart';
import 'package:dw_bike_trips_client/session/trips_history.dart';
import 'package:dw_bike_trips_client/widgets/themed/heading.dart';
import 'package:dw_bike_trips_client/widgets/themed/icon.dart';
import 'package:dw_bike_trips_client/widgets/themed/text.dart';
import 'package:flutter/material.dart';
import 'package:graphql_flutter/graphql_flutter.dart';
import 'package:provider/provider.dart';

class DeleteTripChange extends Change {
  final Trip _trip;
  final TripsHistory _tripsController;
  final DashboardController _dashboardController;

  DeleteTripChange(Trip trip, this._tripsController, this._dashboardController)
      : _trip = trip;

  Trip get trip => _trip;

  @override
  Widget buildIcon(BuildContext context) {
    return const ThemedIcon(
      icon: Icons.remove_circle_outline,
    );
  }

  @override
  Widget buildWidget(BuildContext context) {
    Session session = context.watch<Session>();
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        ThemedHeading(
          caption: session.formatDistance(trip.distance),
        ),
        ThemedText(
          text: session.formatTimestamp(trip.timestamp),
          textSize: ThemedTextSize.small,
        ),
      ],
    );
  }

  @override
  ValuedOperation<bool> createOperation(GraphQLClient client) {
    return DeleteTripsOperation(
        client, _tripsController, [trip], _dashboardController);
  }

  @override
  bool canEdit() {
    return false;
  }
}
