import 'package:dw_bike_trips_client/theme_data.dart';
import 'package:dw_bike_trips_client/widgets/themed/button.dart';
import 'package:dw_bike_trips_client/widgets/themed/heading.dart';
import 'package:dw_bike_trips_client/widgets/themed/text.dart';
import 'package:flutter/material.dart';

void message(
  BuildContext context, {
  String title = 'Hinweis',
  required String message,
  required IconData okIcon,
  String okText = "OK",
}) {
  showDialog(
    context: context,
    builder: (context) => AlertDialog(
      title: ThemedHeading(
        caption: title,
      ),
      backgroundColor: AppThemeData.mainDarkerColor,
      content: ThemedText(
        textAlign: TextAlign.start,
        text: message,
      ),
      actions: [
        ThemedButton(
          caption: okText,
          icon: okIcon,
          onPressed: () {
            Navigator.of(context).pop();
          },
        ),
      ],
    ),
  );
}

void confirm(
  BuildContext context, {
  String title = 'Confirmation',
  required String message,
  required IconData okIcon,
  String okText = "OK",
  String cancelText = "Cancel",
  required Function onConfirmed,
}) {
  showDialog(
    context: context,
    builder: (context) => AlertDialog(
      title: ThemedHeading(
        caption: title,
      ),
      backgroundColor: AppThemeData.mainDarkerColor,
      content: ThemedText(
        textAlign: TextAlign.start,
        text: message,
      ),
      actions: [
        ThemedButton(
          caption: okText,
          icon: okIcon,
          onPressed: () {
            onConfirmed();
            Navigator.of(context).pop();
          },
        ),
        ThemedButton(
          caption: cancelText,
          flat: true,
          onPressed: () {
            Navigator.of(context).pop();
          },
        )
      ],
    ),
  );
}
