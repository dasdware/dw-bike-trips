import 'package:dw_bike_trips_client/session/session.dart';
import 'package:dw_bike_trips_client/widgets/page.dart';
import 'package:dw_bike_trips_client/widgets/themed/heading.dart';
import 'package:dw_bike_trips_client/widgets/themed/panel.dart';
import 'package:dw_bike_trips_client/widgets/themed/scaffold.dart';
import 'package:dw_bike_trips_client/widgets/themed/spacing.dart';
import 'package:flutter/material.dart';
import 'package:provider/provider.dart';

class UploadChangesPage extends StatelessWidget {
  const UploadChangesPage({Key key}) : super(key: key);

  _postPressed(BuildContext context) async {
    Session session = context.read<Session>();
    if (
      await session.changesQueue.performChanges(
        ApplicationPage.of(context).pageName,
        session.currentLogin.client,
      )
    ) {
      Navigator.of(context).pop();
    }
  }

  @override
  Widget build(BuildContext context) {
    Session session = context.watch<Session>();
    return ThemedScaffold(
      pageName: 'uploadChanges',
      appBar: themedAppBar(
        title: const ThemedHeading(
          caption: "Upload changes",
          style: ThemedHeadingStyle.big,
        ),
      ),
      body: Padding(
        padding: const EdgeInsets.all(8.0),
        child: ListView(
          children: session.changesQueue.changes
              .map(
                (trip) => ThemedPanel(
                  margin: const EdgeInsets.symmetric(vertical: 8.0, horizontal: 16.0),
                  padding:
                      const EdgeInsets.symmetric(vertical: 12.0, horizontal: 16.0),
                  child: Row(
                    children: [
                      trip.buildIcon(context),
                      const ThemedSpacing(),
                      trip.buildWidget(context),
                    ],
                  ),
                ),
              )
              .toList(),
        ),
      ),
      floatingActionButton: Builder(
        builder: (context) => FloatingActionButton(
          child: const Icon(Icons.cloud_upload_outlined),
          onPressed: () async {
            _postPressed(context);
          },
        ),
      ),
    );
  }
}
