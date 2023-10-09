import 'package:dw_bike_trips_client/queries.dart' as queries;
import 'package:dw_bike_trips_client/session/dashboard.dart';
import 'package:dw_bike_trips_client/session/operations.dart';
import 'package:dw_bike_trips_client/session/operations/client.dart';
import 'package:graphql_flutter/graphql_flutter.dart';

class DashboardOperation extends ValuedOperation<Dashboard> {
  final GraphQLClient client;
  final queries.AccumulationKind accumulationKind;

  DashboardOperation(this.client,
      {this.accumulationKind = queries.AccumulationKind.months})
      : super('dashboard', 'Fetching data for dashboard.');

  @override
  Future<ValuedOperationResult<Dashboard>> perform(
      String pageName, OperationContext context) {
    var accumulationParameters =
        queries.AccumulationQueryParameters(accumulationKind);

    return doGraphQL(client, queries.dashboard(accumulationParameters),
        (result) {
      var distances = DashboardDistances(
        today: result['dashboard']['distances']['today'].toDouble(),
        yesterday: result['dashboard']['distances']['yesterday'].toDouble(),
        thisWeek: result['dashboard']['distances']['thisWeek'].toDouble(),
        lastWeek: result['dashboard']['distances']['lastWeek'].toDouble(),
        thisMonth: result['dashboard']['distances']['thisMonth'].toDouble(),
        lastMonth: result['dashboard']['distances']['lastMonth'].toDouble(),
        thisYear: result['dashboard']['distances']['thisYear'].toDouble(),
        lastYear: result['dashboard']['distances']['lastYear'].toDouble(),
        allTime: result['dashboard']['distances']['allTime'].toDouble(),
      );

      var history = <DashboardHistoryEntry>[];
      var expectedGroup = accumulationParameters.toGroupNumber;
      var expectedItem = accumulationParameters.toItemNumber;

      var index = 0;
      var entryList = result['accumulateTrips'];
      for (var item = 0; item < accumulationParameters.itemCount; ++item) {
        dynamic entry;
        var entryGroup = -1;
        var entryItem = -1;

        if (entryList != null && entryList.length > index) {
          entry = entryList[index];
          var numEntryName = int.parse(entry['name']);
          entryGroup = numEntryName ~/ 100;
          entryItem = numEntryName % 100;
        }

        if (entryGroup == expectedGroup && entryItem == expectedItem) {
          history.add(DashboardHistoryEntry(
              entryGroup, entryItem, entry['count'], entry['distance'] + 0.0));
          ++index;
        } else {
          history
              .add(DashboardHistoryEntry(expectedGroup, expectedItem, 0, 0.0));
        }

        --expectedItem;
        if (expectedItem == 0) {
          --expectedGroup;
          expectedItem = accumulationParameters.prevMaxItemNumber;
        }
      }

      return Dashboard(distances: distances, history: history);
    });
  }
}
