import 'package:dw_bike_trips_client/theme_data.dart';
import 'package:dw_bike_trips_client/widgets/themed/icon.dart';
import 'package:flutter/material.dart';

class ThemedIconButton extends StatelessWidget {
  final IconData? icon;
  final Widget? iconWidget;
  final String? overlayText;
  final IconData? overlayIcon;
  final void Function()? onPressed;
  final String? tooltip;

  const ThemedIconButton({
    super.key,
    this.icon,
    this.iconWidget,
    this.overlayText,
    this.overlayIcon,
    this.onPressed,
    this.tooltip,
  });

  Widget _iconWidget() {
    return (iconWidget != null)
        ? iconWidget!
        : ThemedIcon(
            icon: icon,
            overlayIcon: overlayIcon,
            overlayText: overlayText,
            color: AppThemeData.activeColor,
          );
  }

  @override
  Widget build(BuildContext context) {
    return IconButton(
      icon: _iconWidget(),
      onPressed: onPressed,
      tooltip: tooltip,
    );
  }
}
