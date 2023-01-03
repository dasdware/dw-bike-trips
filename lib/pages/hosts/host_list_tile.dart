import 'package:dw_bike_trips_client/session/hosts.dart';
import 'package:dw_bike_trips_client/session/session.dart';
import 'package:dw_bike_trips_client/theme_data.dart';
import 'package:dw_bike_trips_client/widgets/themed/button.dart';
import 'package:dw_bike_trips_client/widgets/themed/heading.dart';
import 'package:dw_bike_trips_client/widgets/themed/panel.dart';
import 'package:dw_bike_trips_client/widgets/themed/icon_button.dart';
import 'package:dw_bike_trips_client/widgets/themed/spacing.dart';
import 'package:dw_bike_trips_client/widgets/themed/text.dart';
import 'package:dw_bike_trips_client/widgets/themed/icon.dart';
import 'package:flutter/material.dart';
import 'package:provider/provider.dart';

class HostListTile extends StatelessWidget {
  final Host _host;

  const HostListTile({Key key, @required Host host})
      : _host = host,
        super(key: key);

  void _activateHost(BuildContext context) {
    context.read<Session>().hosts.setActiveHost(_host);
  }

  _removeHost(BuildContext context) {
    showDialog(
      context: context,
      builder: (context) => AlertDialog(
        title: const ThemedHeading(
          caption: 'Remove host',
        ),
        backgroundColor: AppThemeData.mainDarkerColor,
        content: const ThemedText(
          textAlign: TextAlign.start,
          text:
              'Are you sure you want to remove the selected host? This operation cannot be undone.',
        ),
        actions: [
          ThemedButton(
            caption: 'Remove',
            icon: Icons.delete,
            onPressed: () {
              context.read<Session>().hosts.removeHost(_host);
              Navigator.of(context).pop();
            },
          ),
          ThemedButton(
            caption: 'Cancel',
            flat: true,
            onPressed: () {
              Navigator.of(context).pop();
            },
          )
        ],
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    return Padding(
      padding: const EdgeInsets.fromLTRB(8.0, 4.0, 8.0, 4.0),
      child: ThemedPanel(
        style: _host.active
            ? ThemedPanelStyle.mostEmphasized
            : ThemedPanelStyle.normal,
        child: Padding(
          padding: const EdgeInsets.fromLTRB(0.0, 8.0, 0.0, 8.0),
          child: Row(
            children: [
              ThemedIconButton(
                icon: _host.active
                    ? Icons.radio_button_on
                    : Icons.radio_button_off,
                onPressed: () => _activateHost(context),
              ),
              const ThemedSpacing(),
              Expanded(
                child: Opacity(
                  opacity: _host.active ? 1.0 : 0.8,
                  child: Wrap(
                    direction: Axis.vertical,
                    children: [
                      Row(
                        children: [
                          const ThemedIcon(icon: Icons.cloud_outlined),
                          const ThemedSpacing(),
                          ThemedText(
                            text: _host.name,
                          ),
                        ],
                      ),
                      ThemedText(
                        text: _host.url,
                        textSize: ThemedTextSize.small,
                      ),
                    ],
                  ),
                ),
              ),
              const ThemedSpacing(),
              ThemedIconButton(
                icon: Icons.delete,
                onPressed: () => _removeHost(context),
              ),
            ],
          ),
        ),
      ),
    );
  }
}
