import 'dart:async';

import 'package:dw_bike_trips_client/session/operations.dart';
import 'package:graphql_builder/graphql_builder.dart';
import 'package:graphql_flutter/graphql_flutter.dart';

const Duration _timeout = Duration(seconds: 5);

typedef T Converter<T>(dynamic value);

Future<ValuedOperationResult<T>> doGraphQL<T>(
    GraphQLClient client, Document request, Converter<T> converter,
    {Map<String, dynamic> variables, bool mutation = false}) async {
  try {
    var result = (mutation)
        ? await client
            .mutate(
              MutationOptions(
                documentNode: gql(request.bake()),
                variables: variables,
              ),
            )
            .timeout(_timeout)
        : await client
            .query(
              QueryOptions(
                documentNode: gql(request.bake()),
                variables: variables,
              ),
            )
            .timeout(_timeout);

    if (result.hasException) {
      return ValuedOperationResult<T>.withErrors(result.exception.graphqlErrors
          .map((e) => OperationError(e.message))
          .toList());
    } else {
      return ValuedOperationResult<T>.withSuccess(converter(result.data));
    }
  } on TimeoutException catch (_) {
    return ValuedOperationResult<T>.withErrors(
        [OperationError('Timeout while trying to connect to server')]);
  }
}
