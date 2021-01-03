import 'package:dw_bike_trips_client/session/hosts.dart';

class JSONHosts {
  String activeHost;
  List<JSONHost> hosts;

  JSONHosts({this.activeHost, this.hosts});

  JSONHosts.fromHosts(Hosts hosts)
      : activeHost = (hosts.activeHost != null) ? hosts.activeHost.url : "",
        hosts = hosts.entries.map((host) => JSONHost.fromHost(host)).toList();

  JSONHosts.fromJson(Map<String, dynamic> json) {
    activeHost = json['activeHost'];
    if (json['hosts'] != null) {
      hosts = new List<JSONHost>();
      json['hosts'].forEach((v) {
        hosts.add(new JSONHost.fromJson(v));
      });
    }
  }

  Hosts toHosts() {
    var hosts = Hosts();
    for (var host in this.hosts) {
      Host loadedHost = Host(host.name, host.url);
      loadedHost.active = (activeHost == host.url);
      hosts.entries.add(loadedHost);
    }
    return hosts;
  }

  Map<String, dynamic> toJson() {
    final Map<String, dynamic> data = new Map<String, dynamic>();
    data['activeHost'] = this.activeHost;
    if (this.hosts != null) {
      data['hosts'] = this.hosts.map((v) => v.toJson()).toList();
    }
    return data;
  }
}

class JSONHost {
  String url;
  String name;

  JSONHost({this.url, this.name});

  JSONHost.fromHost(Host host)
      : url = host.url,
        name = host.name;

  JSONHost.fromJson(Map<String, dynamic> json) {
    url = json['url'];
    name = json['name'];
  }

  Map<String, dynamic> toJson() {
    final Map<String, dynamic> data = new Map<String, dynamic>();
    data['url'] = this.url;
    data['name'] = this.name;
    return data;
  }
}
