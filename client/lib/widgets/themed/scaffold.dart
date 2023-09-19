import 'package:dw_bike_trips_client/session/operations.dart';
import 'package:dw_bike_trips_client/session/session.dart';
import 'package:dw_bike_trips_client/widgets/page.dart';
import 'package:dw_bike_trips_client/widgets/themed/background.dart';
import 'package:dw_bike_trips_client/widgets/themed/error_indicator.dart';
import 'package:dw_bike_trips_client/widgets/themed/progress_indicator.dart';
import 'package:flutter/material.dart';
import 'package:provider/provider.dart';

PreferredSizeWidget themedAppBar(
    {Key? key, List<Widget>? actions, Widget? title}) {
  return AppBar(
    key: key,
    backgroundColor: Colors.transparent,
    elevation: 0.0,
    title: title,
    actions: actions,
  );
}

class ThemedScaffold extends StatelessWidget {
  final Widget? body;
  final PreferredSizeWidget? appBar;
  final Widget? floatingActionButton;
  final Widget? endDrawer;
  final bool extendBodyBehindAppBar;
  final String pageName;

  const ThemedScaffold({
    super.key,
    this.body,
    this.appBar,
    this.floatingActionButton,
    this.endDrawer,
    this.extendBodyBehindAppBar = true,
    required this.pageName,
  });

  @override
  Widget build(BuildContext context) {
    return ApplicationPage(
      pageName: pageName,
      child: ThemedBackground(
        child: StreamBuilder<Operation?>(
            stream:
                context.watch<Session>().operationContext.activeOperationStream,
            initialData:
                context.watch<Session>().operationContext.activeOperation,
            builder: (context, snapshot) {
              var operationContext = context.watch<Session>().operationContext;
              return Stack(
                children: [
                  Scaffold(
                    backgroundColor: Colors.transparent,
                    endDrawer: endDrawer,
                    appBar: appBar,
                    body: body,
                    floatingActionButton: floatingActionButton,
                    extendBodyBehindAppBar: extendBodyBehindAppBar,
                  ),
                  if (operationContext.hasActiveOperation)
                    ThemedProgressIndicator(
                      operationContext.activeOperation!.title,
                    ),
                  const ErrorIndicator()
                ],
              );
            }),
      ),
    );
  }
}
