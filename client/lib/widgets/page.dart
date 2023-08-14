import 'package:flutter/material.dart';

class ApplicationPage extends InheritedWidget {
  final String pageName;

  const ApplicationPage({
    super.key,
    required super.child,
    required this.pageName,
  });

  static ApplicationPage of(BuildContext context) {
    final ApplicationPage? result =
        context.dependOnInheritedWidgetOfExactType<ApplicationPage>();
    assert(result != null, 'No Page found in context');
    return result!;
  }

  @override
  bool updateShouldNotify(ApplicationPage oldWidget) {
    return oldWidget.pageName != pageName;
  }
}
