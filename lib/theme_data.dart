import 'package:flutter/material.dart';

class AppThemeData {
  static const panelBackground = const Color.fromRGBO(255, 255, 255, 0.1);
  static const panelEmphasizedBackground =
      const Color.fromRGBO(255, 255, 255, 0.15);
  static const panelMostEmphasizedBackground =
      const Color.fromRGBO(255, 255, 255, 0.2);
  static const panelBorderRadius = 4.0;

  static const spacing = 8.0;
  static const largeSpacing = 16.0;

  static const headingColor = const Color.fromRGBO(255, 255, 255, 0.7);
  static const headingMediumColor = const Color.fromRGBO(255, 255, 255, 0.8);
  static const headingBigColor = const Color.fromRGBO(255, 255, 255, 0.9);
  static const headingSmallFontSize = 12.0;
  static const headingMediumFontSize = 16.0;
  static const headingBigFontSize = 20.0;

  static const mainLightestColor = Color(0xFF837EB1);
  static const mainLighterColor = Color(0xFF5B5494);
  static const mainColor = Color(0xFF393276);
  static const mainDarkerColor = Color(0xFF1F1959);
  static const mainDarkestColor = Color(0xFF0D083B);

  static const textColor = Colors.white;
  static const textSize = 16.0;

  static const highlightColor = Color(0xFFD4BD6A);
  static const highlightLighterColor = Color(0xFFFFECAA);
  static const highlightDarkerColor = Color(0xFF806815);
  static const highlightDarkestColor = Color(0xFF2e2400);

  static const activeColor = highlightColor;
  static const activeLighterColor = highlightLighterColor;
  static const activeDarkerColor = highlightDarkerColor;
  static const activeDarkestColor = highlightDarkestColor;

  static const tooltipBackground = const Color.fromRGBO(0, 0, 0, 0.6);

  static const currentValue = mainLightestColor;
  static const referenceValue = mainLighterColor;

  static final themeData = ThemeData(
    appBarTheme: AppBarTheme(
      color: Colors.transparent,
      iconTheme: IconThemeData(
        color: Colors.white,
      ),
    ),
    primaryColor: AppThemeData.mainDarkestColor,
    visualDensity: VisualDensity.adaptivePlatformDensity,
    scaffoldBackgroundColor: Colors.transparent,
    floatingActionButtonTheme: FloatingActionButtonThemeData(
      backgroundColor: AppThemeData.activeColor,
      foregroundColor: AppThemeData.activeDarkestColor,
    ),
  );
}
