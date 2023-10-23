import 'package:dw_bike_trips_client/theme_data.dart';
import 'package:flutter/material.dart';

class EditIcon extends StatelessWidget {
  final Color color;
  const EditIcon({super.key, this.color = AppThemeData.activeColor});

  @override
  Widget build(BuildContext context) {
    return Container(
      height: 20,
      width: 20,
      decoration: BoxDecoration(
        // color: AppThemeData.activeColor,
        borderRadius: BorderRadius.circular(12),
        border: Border.all(
          color: color,
          width: 2.5,
        ),
      ),
      child: Icon(
        Icons.edit,
        size: 12,
        color: color,
      ),
    );
  }
}
