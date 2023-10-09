import 'package:dw_bike_trips_client/session/operations/timestamp.dart';
import 'package:dw_bike_trips_client/session/trip.dart';
import 'package:jiffy/jiffy.dart';

const serverInfo = """
  query serverInfo {
    serverInfo {
      name
    }
  }
""";

const login = """
  query (\$email: String!, \$password: String!) {
    login(email: \$email, password: \$password) {
      token
    }
  }
""";

const me = """
  query {
    me {
      email
      firstname
      lastname
    }
  }
""";

String postTrips(List<Trip> trips) {
  return """
    mutation {
      postTrips(
        trips: [
          ${trips.map((trip) => "{timestamp: \"${trip.timestamp.toString()}\", distance: ${trip.distance}}").join("\n")}
        ]
      )
    }
  """;
}

String editTrips(List<Trip> trips) {
  return """
    mutation {
      editTrips(
        trips: [
          ${trips.map((trip) => "{id: ${trip.id}, timestamp: \"${trip.timestamp.toString()}\", distance: ${trip.distance}}").join("\n")}
        ]
      )
    }
  """;
}

String deleteTrips(List<Trip> trips) {
  return """
    mutation {
      deleteTrips(
        trips: [
          ${trips.map((trip) => "{id: ${trip.id}}").join("\n")}
        ]
      )
    }
  """;
}

const countTrips = """
  query countTrips {
    countTrips {
      count
      begin
      end
    }
  }
""";

const trips = """
  query (\$limit: Int!, \$offset: Int!) {
    trips(
        limit: { count: \$limit, offset: \$offset }
    ) {
      id
      timestamp
      distance
    }
  }
""";

// Modes:
//  14 Days
//  12 Weeks
//  12 Months (1 year)
//  10 Years

enum AccumulationKind { days, weeks, months, years, all }

class AccumulationQueryParameters {
  final AccumulationKind accumulationKind;
  final Timestamp? from;
  final Timestamp to;

  AccumulationQueryParameters(this.accumulationKind)
      : to = Timestamp.now(),
        from = AccumulationQueryParameters._calculateFrom(accumulationKind);

  static int _calculateItemCount(
    AccumulationKind accumulationKind,
  ) {
    switch (accumulationKind) {
      case AccumulationKind.days:
        return 14;
      case AccumulationKind.weeks:
        return 12;
      case AccumulationKind.months:
        return 12;
      case AccumulationKind.years:
        return 5;
      case AccumulationKind.all:
        return 10;
    }
  }

  static Timestamp? _calculateFrom(
    AccumulationKind accumulationKind,
  ) {
    var to = Timestamp.now();
    switch (accumulationKind) {
      case AccumulationKind.days:
        return to.subtract(
            days: AccumulationQueryParameters._calculateItemCount(
                accumulationKind));
      case AccumulationKind.weeks:
        return to.subtract(
            weeks: AccumulationQueryParameters._calculateItemCount(
                accumulationKind));
      case AccumulationKind.months:
        return to.subtract(
            months: AccumulationQueryParameters._calculateItemCount(
                accumulationKind));
      case AccumulationKind.years:
        return to.subtract(
            years: AccumulationQueryParameters._calculateItemCount(
                accumulationKind));
      case AccumulationKind.all:
        return to.subtract(
            years: AccumulationQueryParameters._calculateItemCount(
                accumulationKind));
    }
  }

  String get range {
    if (from == null) {
      return """{to: "${to.toString()}"}""";
    } else {
      return """{from: "${from.toString()}", to: "${to.toString()}"}""";
    }
  }

  String get grouping {
    switch (accumulationKind) {
      case AccumulationKind.days:
        return "day";
      case AccumulationKind.weeks:
        return "week";
      case AccumulationKind.months:
        return "month";
      case AccumulationKind.years:
      case AccumulationKind.all:
        return "year";
    }
  }

  int get itemCount {
    return AccumulationQueryParameters._calculateItemCount(accumulationKind);
  }

  int get toItemNumber {
    switch (accumulationKind) {
      case AccumulationKind.days:
        return to.day;
      case AccumulationKind.weeks:
        return to.week;
      case AccumulationKind.months:
        return to.month;
      case AccumulationKind.years:
      case AccumulationKind.all:
        return to.year % 100;
    }
  }

  int get prevMaxItemNumber {
    switch (accumulationKind) {
      case AccumulationKind.days:
        return Jiffy.parseFromDateTime(to.toDateTime())
            .subtract(months: 1)
            .daysInMonth;
      case AccumulationKind.weeks:
        return 52;
      case AccumulationKind.months:
        return 12;
      case AccumulationKind.years:
      case AccumulationKind.all:
        return 99;
    }
  }

  int get toGroupNumber {
    switch (accumulationKind) {
      case AccumulationKind.days:
        return to.year * 100 + to.month;
      case AccumulationKind.weeks:
        return to.year;
      case AccumulationKind.months:
        return to.year;
      case AccumulationKind.years:
      case AccumulationKind.all:
        return to.year ~/ 100;
    }
  }
}

String dashboard(AccumulationQueryParameters parameters) {
  return """
    query completeDashboard {
      dashboard {
        distances {today yesterday thisWeek lastWeek thisMonth lastMonth thisYear lastYear allTime }
      }
      accumulateTrips(
        range: ${parameters.range},
        grouping: ${parameters.grouping}
      ) {
        name
        begin
        end
        count
        distance
      }
    }
  """;
}
