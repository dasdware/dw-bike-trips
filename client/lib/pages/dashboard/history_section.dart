import 'package:dw_bike_trips_client/queries.dart';
import 'package:dw_bike_trips_client/session/dashboard.dart';
import 'package:dw_bike_trips_client/session/operations/timestamp.dart';
import 'package:dw_bike_trips_client/session/session.dart';
import 'package:dw_bike_trips_client/theme_data.dart';
import 'package:dw_bike_trips_client/widgets/themed/heading.dart';
import 'package:dw_bike_trips_client/widgets/themed/panel.dart';
import 'package:dw_bike_trips_client/widgets/themed/spacing.dart';
import 'package:fl_chart/fl_chart.dart';
import 'package:flutter/material.dart';
import 'package:provider/provider.dart';

class DashboardHistoryEntryBarChartGroupData extends BarChartGroupData {
  final DashboardHistoryEntry entry;
  DashboardHistoryEntryBarChartGroupData(
      int x, double maxDistance, this.entry, bool isTouched)
      : super(
          x: x,
          barRods: [
            BarChartRodData(
              toY: entry.distance,
              color: isTouched
                  ? AppThemeData.activeColor
                  : AppThemeData.headingColor,
              width: 16,
              backDrawRodData: BackgroundBarChartRodData(
                show: true,
                toY: maxDistance,
                color: AppThemeData.panelBackgroundColor.withOpacity(
                    AppThemeData.panelBackgroundMostEmphasizedOpacity),
              ),
            ),
          ],
        );
}

class DashboardHistorySection extends StatefulWidget {
  final List<DashboardHistoryEntry> history;

  const DashboardHistorySection({super.key, required this.history});

  @override
  State<StatefulWidget> createState() => DashboardHistorySectionState();
}

class DashboardHistorySectionState extends State<DashboardHistorySection> {
  final Duration animDuration = const Duration(milliseconds: 250);

  int touchedIndex = -1;

  Widget createAccumulationKindItem(AccumulationKind kind) {
    switch (kind) {
      case AccumulationKind.days:
        return const Text('Days');
      case AccumulationKind.weeks:
        return const Text('Weeks');
      case AccumulationKind.months:
        return const Text('Months');
      case AccumulationKind.years:
        return const Text('Years');
      case AccumulationKind.all:
      default:
        return const Text('Everything');
    }
  }

  @override
  Widget build(BuildContext context) {
    var dashboardController = context.watch<Session>().dashboardController!;
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        const ThemedHeading(
          caption: 'history',
        ),
        const SizedBox(
          height: 8.0,
        ),
        ThemedPanel(
          child: Padding(
            padding: const EdgeInsets.all(8.0),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.end,
              children: [
                Container(
                  decoration: const BoxDecoration(
                    color: AppThemeData.mainDarkerColor,
                    borderRadius: BorderRadius.all(Radius.circular(4.0)),
                  ),
                  child: DropdownButton<AccumulationKind>(
                    borderRadius: const BorderRadius.all(Radius.circular(4.0)),
                    value: dashboardController.accumulationKind,
                    icon: const Icon(
                      Icons.expand_more,
                      color: AppThemeData.activeColor,
                    ),
                    dropdownColor: AppThemeData.mainDarkerColor,
                    underline: Container(),
                    style: const TextStyle(color: AppThemeData.activeColor),
                    padding: const EdgeInsets.symmetric(horizontal: 16.0),
                    onChanged: (AccumulationKind? value) {
                      dashboardController.accumulationKind = value!;
                    },
                    items: AccumulationKind.values
                        .map<DropdownMenuItem<AccumulationKind>>(
                            (AccumulationKind value) {
                      return DropdownMenuItem<AccumulationKind>(
                        value: value,
                        child: createAccumulationKindItem(value),
                      );
                    }).toList(),
                  ),
                ),
                const ThemedSpacing(),
                AspectRatio(
                  aspectRatio: 1,
                  child: BarChart(
                    buildChartData(context, widget.history),
                    key: Key(dashboardController.accumulationKind.toString()),
                    swapAnimationDuration: animDuration,
                  ),
                ),
              ],
            ),
          ),
        ),
      ],
    );
  }

  List<DashboardHistoryEntryBarChartGroupData> buildChartBars(
      List<DashboardHistoryEntry> history) {
    var maxDistance = 0.0;
    for (var entry in history) {
      if (maxDistance < entry.distance) {
        maxDistance = entry.distance;
      }
    }

    var result = <DashboardHistoryEntryBarChartGroupData>[];
    for (int i = 0; i < history.length; ++i) {
      result.add(DashboardHistoryEntryBarChartGroupData(
          i, maxDistance, history[history.length - i - 1], i == touchedIndex));
    }
    return result;
  }

  String formatEntry(
    BuildContext context,
    DashboardHistoryEntry entry,
  ) {
    var session = context.read<Session>();
    switch (session.dashboardController!.accumulationKind) {
      case AccumulationKind.days:
        return "${session.formatDate(Timestamp(year: entry.group ~/ 100, month: entry.group % 100, day: entry.item))}\n${session.formatDistance(entry.distance)}";
      case AccumulationKind.months:
      case AccumulationKind.weeks:
        return "${entry.item}/${entry.group}\n${session.formatDistance(entry.distance)}";
      case AccumulationKind.all:
      case AccumulationKind.years:
      default:
        return "${entry.group * 100 + entry.item}\n${session.formatDistance(entry.distance)}";
    }
  }

  BarChartData buildChartData(
      BuildContext context, List<DashboardHistoryEntry> history) {
    var barGroups = buildChartBars(history);
    return BarChartData(
      barTouchData: BarTouchData(
        touchTooltipData: BarTouchTooltipData(
            tooltipBgColor: AppThemeData.tooltipBackground,
            getTooltipItem: (group, groupIndex, rod, rodIndex) {
              var entry = barGroups[group.x].entry;
              return BarTooltipItem(
                formatEntry(context, entry),
                const TextStyle(
                  color: AppThemeData.highlightColor,
                  fontWeight: FontWeight.w500,
                ),
              );
            }),
        touchCallback: (event, barTouchResponse) {
          setState(() {
            if (barTouchResponse?.spot != null) {
              touchedIndex = barTouchResponse!.spot!.touchedBarGroupIndex;
            } else {
              touchedIndex = -1;
            }
          });
        },
      ),
      titlesData: FlTitlesData(
        show: true,
        bottomTitles: AxisTitles(
          sideTitles: SideTitles(
            showTitles: true,
            getTitlesWidget: (value, meta) => SideTitleWidget(
              axisSide: AxisSide.bottom,
              child: Text(
                barGroups[value.toInt()].entry.item.toString(),
                style: const TextStyle(
                    color: AppThemeData.headingColor,
                    fontWeight: FontWeight.w500,
                    fontSize: 14),
              ),
            ),
          ),
        ),
        leftTitles: const AxisTitles(
          sideTitles: SideTitles(
            showTitles: false,
          ),
        ),
        rightTitles: const AxisTitles(
          sideTitles: SideTitles(
            showTitles: false,
          ),
        ),
        topTitles: const AxisTitles(
          sideTitles: SideTitles(
            showTitles: false,
          ),
        ),
      ),
      borderData: FlBorderData(
        show: false,
      ),
      barGroups: barGroups,
      gridData: const FlGridData(
        show: false,
      ),
    );
  }
}
