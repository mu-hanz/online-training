! function(o) {
    "use strict";
    var base_url = window.location.origin;
    function t() {}
    t.prototype.initCharts = function() {
        var t = {
            chart: {
                type: "area",
                height: 45,
                width: 90,
                sparkline: {
                    enabled: !0
                },
                events: {
                    beforeMount: function (chartContext, config) {
                        $('.chart-small').block({
                            message: '<div class="spinner-border1 text-primary" role="status"></div>',
                            overlayCSS: {
                                backgroundColor: "#fff",
                                cursor: 'wait',
                            },
                            css: {
                                border: 0,
                                padding: 0,
                                backgroundColor: 'none'
                            }
                        });
                    },
                    mounted:function (chartContext, config) {
                        $('.chart-small').unblock();
                    }
                  }
            },
            series: [],
            stroke: {
                width: 2,
                curve: "smooth"
            },
            markers: {
                size: 0
            },
            colors: ["#727cf5"],
            tooltip: {
                fixed: {
                    enabled: !(window.Apex = {
                        chart: {
                            parentHeightOffset: 0,
                            toolbar: {
                                show: !1
                            }
                        },
                        grid: {
                            padding: {
                                left: 0,
                                right: 0
                            }
                        },
                        colors: [],
                        tooltip: {
                            theme: "dark",
                            x: {
                                show: !1
                            }
                        }
                    })
                },
                x: {
                    show: !1
                },
                y: {
                    title: {
                        formatter: function(t) {
                            return ""
                        }
                    }
                },
                marker: {
                    show: !1
                }
            },
            fill: {
                type: "gradient",
                gradient: {
                    type: "vertical",
                    shadeIntensity: 1,
                    inverseColors: !1,
                    opacityFrom: .45,
                    opacityTo: .05,
                    stops: [45, 100]
                }
            }
        };

        var chart1 =new ApexCharts(document.querySelector("#today-revenue-chart"), o.extend({}, t, {
            colors: ["#5369f8"]
        }));

        chart1.render();
        var url1 = base_url +'/webadmin/dashboard/data';

        $.getJSON(url1, function(response) {
            chart1.updateSeries([{
            data: response.value_days
        }])
        });

        var chart2 =new ApexCharts(document.querySelector("#today-product-sold-chart"), o.extend({}, t, {
            colors: ["#43d39e"]
        }));

        chart2.render();
        var url2 = base_url +'/webadmin/dashboard/data';

        $.getJSON(url2, function(response) {
            chart2.updateSeries([{
            data: [25, 3, 41, 84, 63, 25, 4, 12, 36, 9, 54]
        }])
        });

        var chart3 =new ApexCharts(document.querySelector("#today-new-customer-chart"), o.extend({}, t, {
            colors: ["#f77e53"]
        }));

        chart3.render();
        var url3 = base_url +'/webadmin/dashboard/data';

        $.getJSON(url3, function(response) {
            chart3.updateSeries([{
            data: [25, 3, 41, 84, 3, 25, 44, 12, 36, 9, 54]
        }])
        });

        var chart4 =new ApexCharts(document.querySelector("#today-new-visitors-chart"), o.extend({}, t, {
            colors: ["#ffbe0b"]
        }));

        chart4.render();
        var url4 = base_url +'/webadmin/dashboard/data';

        $.getJSON(url4, function(response) {
            chart4.updateSeries([{
            data: [25, 3, 41, 84, 63, 25, 44, 12, 36, 9, 54]
        }])
        });
        
         var  r = {
                chart: {
                    height: 296,
                    type: "area",
                    zoom: {
                        enabled: false
                      },
                      events: {
                        beforeMount: function (chartContext, config) {
                            $('.chart-big').block({
                                message: '<div class="spinner-border text-primary" role="status"></div>',
                                overlayCSS: {
                                    backgroundColor: "#fff",
                                    cursor: 'wait',
                                },
                                css: {
                                    border: 0,
                                    padding: 0,
                                    backgroundColor: 'none'
                                }
                            });
                        },
                        mounted:function (chartContext, config) {
                            $('.chart-big').unblock();
                        }
                      }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: "smooth",
                    width: 4
                },
                series: [],
                legend: {
                    show: true,
                },
                colors: ["#5369f8","#43d39e","#ffbe0b"],
                xaxis: {
                    type: "string",
                    categories: []
                },
                yaxis: {
                    show: true
                  },
          
                fill: {
                    type: "gradient",
                    gradient: {
                        type: "vertical",
                        shadeIntensity: 1,
                        inverseColors: !1,
                        opacityFrom: .45,
                        opacityTo: .05,
                        stops: [45, 100]
                    }
                }
            };
        

            var chart5 = new ApexCharts(document.querySelector("#revenue-chart"), r);
            var url5 = window.location.origin +'/webadmin/dashboard/data_visitor';
            chart5.render();

            $.getJSON(url5, function(response) {
                chart5.updateOptions({
                    xaxis: {
                        type: 'string',
                        categories: response,
                    },
                })
            });

            var url6 = window.location.origin +'/webadmin/dashboard/data_visitor_all';

            $.getJSON(url6, function(response) {
                chart5.updateSeries([
                {
                    name : 'Total Visitor',
                    data: response.all_visitor
                },
                {
                    name : 'Unique Visitor',
                    data: response.unique_visitor 
                },
                {
                    name : 'Page View',
                    data: response.page_view 
                }
            ])
            });

        
    }, t.prototype.init = function() {
         this.initCharts()
    }, o.Dashboard = new t, o.Dashboard.Constructor = t
}(window.jQuery),
function() {
    "use strict";
    window.jQuery.Dashboard.init()
}();