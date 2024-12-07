<script>
    // Order
    var label_monthly = {!! $label_monthly !!};
    var label_quarterly = {!! $label_quarterly !!};
    var label_halfyearly = {!! $label_halfyearly !!};


    var order_yearly = {!! $order_monthly !!};
    var order_quarterly = {!! $order_quarterly !!};
    var order_halfyearly = {!! $order_halfyearly !!};


    function order_chart(){
        var order_chart_type = $("#order_chart_filter").val();
        if(order_chart_type == "yearly"){
            chart_monthly.updateSeries([{ data: order_yearly }]);
            chart_monthly.updateOptions({ xaxis: { categories: label_monthly } });
        }else if(order_chart_type == "halfyearly"){
            chart_monthly.updateSeries([{ data: order_halfyearly }]);
            chart_monthly.updateOptions({ xaxis: { categories: label_halfyearly } });
        }else if(order_chart_type == "quarterly"){
            chart_monthly.updateSeries([{ data: order_quarterly }]);
            chart_monthly.updateOptions({ xaxis: { categories: label_quarterly } });
        }else{
            chart_monthly.updateSeries([{ data: order_yearly }]);
            chart_monthly.updateOptions({ xaxis: { categories: label_monthly } });
        }
    }
    var order_monthly = {
        chart: {
            type: 'bar',
            height: 200,
        },
        series: [{
            name: 'orders',
            data: order_yearly
        }],
        xaxis: {
            categories: label_monthly,
        },
        yaxis: {
            show: false
        },
        dataLabels: {
            enabled: false // Hide the data labels on the bars
        },
        plotOptions: {
            bar: {
                horizontal: false // Set to true if you want horizontal bars
            }
        },
    }
    var chart_monthly = new ApexCharts(document.querySelector("#order_graph"), order_monthly);
    chart_monthly.render();


    var order_complete_yearly = {!! $order_complete_yearly !!};
    var order_complete_quarterly = {!! $order_complete_quarterly !!};
    var order_complete_halfyearly = {!! $order_complete_halfyearly !!};

    

    // var order_complete_chart_options = {
    //     chart: {
    //         type: 'line',
    //     },
    //     series: [{
    //         name: 'orders',
    //         data: order_complete_yearly
    //     }],
    //     xaxis: {
    //         categories: label_monthly,
    //     },
    //     yaxis: {
    //         show: false
    //     },
    //     dataLabels: {
    //         enabled: false // Hide the data labels on the bars
    //     },
    //     plotOptions: {
    //         bar: {
    //             horizontal: false // Set to true if you want horizontal bars
    //         }
    //     },
    //     colors: ['#00ff04'],
    // }


    var order_pending_yearly = {!! $order_pending_yearly !!};
    var order_pending_quarterly = {!! $order_pending_quarterly !!};
    var order_pending_halfyearly = {!! $order_pending_halfyearly !!};

    var order_complete_chart_options = {
          series: [{
          name: 'Complete',
          data: order_complete_yearly,
        }, {
          name: 'Pending',
          data: order_pending_yearly,
        }],
          chart: {
          type: 'bar',
          height: 200,
          stacked: true,
          toolbar: {
            show: true
          },
          zoom: {
            enabled: true
          }
        },
        responsive: [{
          breakpoint: 480,
          options: {
            legend: {
              position: 'bottom',
              offsetX: -10,
              offsetY: 0
            }
          }
        }],
        plotOptions: {
          bar: {
            horizontal: false,
            borderRadius: 10,
            dataLabels: {
              total: {
                enabled: true,
                style: {
                  fontSize: '13px',
                  fontWeight: 900
                }
              }
            }
          },
        },
        xaxis: {
          categories: label_monthly,
        },
        legend: {
          position: 'left',
          offsetY: 40
        },
        fill: {
          opacity: 1,
        }
        };

    var  order_complete_chart = new ApexCharts(document.querySelector("#order_complete_graph"), order_complete_chart_options);
    order_complete_chart.render();


   
    function order_complete_chart_filter(){
        var order_chart_type = $("#order_complete_chart_filter").val();
        if(order_chart_type == "yearly"){
            order_complete_chart.updateSeries([{ data: order_complete_yearly },{ data: order_pending_yearly }]);
            order_complete_chart.updateOptions({ xaxis: { categories: label_monthly } });
        }else if(order_chart_type == "halfyearly"){
            order_complete_chart.updateSeries([{ data: order_complete_quarterly },{ data: order_pending_quarterly }]);
            order_complete_chart.updateOptions({ xaxis: { categories: label_halfyearly } });
        }else if(order_chart_type == "quarterly"){
            order_complete_chart.updateSeries([{ data: order_complete_halfyearly },{ data: order_pending_halfyearly }]);
            order_complete_chart.updateOptions({ xaxis: { categories: label_quarterly } });
        }else{
            order_complete_chart.updateSeries([{ data: order_complete_yearly },{ data: order_pending_yearly }]);
            order_complete_chart.updateOptions({ xaxis: { categories: label_monthly } });
        }
    }

    function order_pending_chart_filter(){
        var order_chart_type = $("#order_pending_chart_filter").val();
        if(order_chart_type == "yearly"){
            order_pending_chart.updateSeries([{ data: order_pending_yearly }]);
            order_pending_chart.updateOptions({ xaxis: { categories: label_monthly } });
        }else if(order_chart_type == "halfyearly"){
            order_pending_chart.updateSeries([{ data: order_pending_quarterly }]);
            order_pending_chart.updateOptions({ xaxis: { categories: label_halfyearly } });
        }else if(order_chart_type == "quarterly"){
            order_pending_chart.updateSeries([{ data: order_pending_halfyearly }]);
            order_pending_chart.updateOptions({ xaxis: { categories: label_quarterly } });
        }else{
            order_pending_chart.updateSeries([{ data: order_pending_yearly }]);
            order_pending_chart.updateOptions({ xaxis: { categories: label_monthly } });
        }
    }

    var order_pending_chart_options = {
        chart: {
            type: 'area'
        },
        series: [{
            name: 'orders',
            data: order_pending_yearly
        }],
        xaxis: {
            categories: label_monthly,
        },
        yaxis: {
            show: false
        },
        dataLabels: {
            enabled: false // Hide the data labels on the bars
        },
        plotOptions: {
            bar: {
                horizontal: false // Set to true if you want horizontal bars
            }
        },
        colors: ['#ff0019'],
    }
    // var  order_pending_chart = new ApexCharts(document.querySelector("#order_pending_graph"), order_pending_chart_options);
    // order_pending_chart.render();

    var order_product_monthly = {!! $order_product_monthly !!};
    var order_product_quarterly = {!! $order_product_quarterly !!};
    var order_product_halfyearly = {!! $order_product_halfyearly !!};

    var order_gram_monthly = {!! $order_gram_monthly !!};
    var order_gram_used_monthly = {!! $order_gram_used_monthly !!};
    var order_gram_quarterly = {!! $order_gram_quarterly !!};
    var order_gram_halfyearly = {!! $order_gram_halfyearly !!};


    var overview_chart_options = {
        chart: {
            type: 'area',
            height: 450
        },
        series: [{
          name: 'By Grams',
          data: order_gram_monthly
        }, {
          name: 'Products',
          data: order_product_monthly
        }, {
          name: 'Orders',
          data: order_yearly
        }
        ],
            xaxis: {
                categories: label_monthly,
            },
            yaxis: {
                show: true
            },
            dataLabels: {
                enabled: true // Hide the data labels on the bars
            },
            plotOptions: {
                bar: {
                    horizontal: false // Set to true if you want horizontal bars
                }
            },
    }

    var overview_bygrams_chart_options = {
        chart: {
            type: 'area'
        },
        series: [{
          name: 'By Grams',
          data: order_gram_monthly
        },
        {
          name: 'By Grams',
          data: order_gram_used_monthly
        }
        ],
            xaxis: {
                categories: label_monthly,
            },
            yaxis: {
                show: true
            },
            dataLabels: {
                enabled: true // Hide the data labels on the bars
            },
            plotOptions: {
                bar: {
                    horizontal: false // Set to true if you want horizontal bars
                }
            },
            colors: ['#008FFB','#05E311'],
    }
    var overview_products_chart_options = {
        chart: {
            type: 'area'
        },
        series: [{
          name: 'Products',
          data: order_product_monthly
        }
        ],
            xaxis: {
                categories: label_monthly,
            },
            yaxis: {
                show: true
            },
            dataLabels: {
                enabled: true // Hide the data labels on the bars
            },
            plotOptions: {
                bar: {
                    horizontal: false // Set to true if you want horizontal bars
                }
            },
            colors: ['#05E398'],
    }
    var overview_orders_chart_options = {
        chart: {
            type: 'area'
        },
        series: [{
          name: 'Orders',
          data: order_yearly
        }
        ],
            xaxis: {
                categories: label_monthly,
            },
            yaxis: {
                show: true
            },
            dataLabels: {
                enabled: true // Hide the data labels on the bars
            },
            plotOptions: {
                bar: {
                    horizontal: false // Set to true if you want horizontal bars
                }
            },
            colors: ['#FEB019'],
    }
    
    function initializeDashboard() {
    // Initialize the initial chart ('overview' chart)
    current_chart = new ApexCharts(document.querySelector("#below_big_graph"), overview_chart_options);
    current_chart.render();

    // Call set_dashboard_big_chart when the page loads to set up the initial chart
    // set_dashboard_big_chart('overview');
}

// Use the DOMContentLoaded event to call the initialization function after the page loads
document.addEventListener('DOMContentLoaded', function () {
    initializeDashboard();
});


var product_wise_lable = {!! $product_namewise_lable !!};
        var product_wise_value = {!! $product_namewise_pice_count !!};
        
      

      var product_wise_graph = {
        chart: {
            type: 'area'
        },
        series: [{
            name: 'Products',
            data: product_wise_value
        }],
        xaxis: {
            categories: product_wise_lable,
        },
        yaxis: {
            show: false
        },
        dataLabels: {
            enabled: false // Hide the data labels on the bars
        },
        plotOptions: {
            bar: {
                horizontal: false // Set to true if you want horizontal bars
            }
        },
        colors: ['#ff0019'],
    }
    var  product_wise_graph_chart = new ApexCharts(document.querySelector("#graph_product_wise"), product_wise_graph);
    product_wise_graph_chart.render();


    var customer_wise_lable = {!! $customer_wise_lable !!};
        var customer_wise_value = {!! $customer_wise_pice_count !!};
        
      

      var customer_wise_graph = {
        chart: {
            type: 'line'
        },
        series: [{
            name: 'Products',
            data: customer_wise_value
        }],
        xaxis: {
            categories: customer_wise_lable,
        },
        yaxis: {
            show: false
        },
        dataLabels: {
            enabled: false // Hide the data labels on the bars
        },
        plotOptions: {
            bar: {
                horizontal: false // Set to true if you want horizontal bars
            }
        },
        colors: ['#ff0019'],
    }
    var customer_wise_graph_chart = new ApexCharts(document.querySelector("#graph_customer_wise"), customer_wise_graph);
    customer_wise_graph_chart.render();


function set_dashboard_big_chart(type){
    if (current_chart) {
      current_chart.destroy();
    }
    $('.dashboard_main_chaty_li').removeClass('active');
    if(type == 'overview'){
        oberview_setting();
         $('#li_overview').addClass('active');
        
        current_chart = new ApexCharts(document.querySelector("#below_big_graph"), overview_chart_options);
        current_chart.render();
    }else if(type == 'bygrams'){
        oberview_setting();
         $('#li_bygrams').addClass('active');
      
        current_chart = new ApexCharts(document.querySelector("#below_big_graph"), overview_bygrams_chart_options);
        current_chart.render();
    }else if(type == 'products'){
        oberview_setting();
         $('#li_products').addClass('active');
    
        current_chart = new ApexCharts(document.querySelector("#below_big_graph"), overview_products_chart_options);
        current_chart.render();
    }else if(type == 'orders'){
        oberview_setting();
         $('#li_orders').addClass('active');
        
        current_chart = new ApexCharts(document.querySelector("#below_big_graph"), overview_orders_chart_options);
        current_chart.render();
    }else if(type == 'product_wise'){

        $('#li_product_wise').addClass('active');
        $("#below_big_graph").hide();
        $("#graph_product_wise").show();
        $("#graph_product_wise_in").val(1);
        $("#graph_customer_wise").hide();
    }else if(type == 'customer_wise'){
        $("#graph_product_wise_in").val(0);
        $('#li_customer_wise').addClass('active');
        $("#below_big_graph").hide();
        $("#graph_product_wise").hide();
        $("#graph_customer_wise").show();
        $("#graph_product_wise_in").val(1);
        }
    else{
        oberview_setting();
         $('#li_overview').addClass('active');
        
        current_chart = new ApexCharts(document.querySelector("#below_big_graph"), overview_chart_options);
        current_chart.render();
    }
        
    }
    function oberview_setting(){
        $("#graph_customer_wise").hide();
        var graph_product_wise_in = $("#graph_product_wise_in").val();
        if(graph_product_wise_in == 1){
            $("#graph_product_wise").hide();  
            $("#below_big_graph").show();
            $("#graph_product_wise_in").val(0);
        }
    }

// Initialize the initial chart (e.g., 'overview' chart)
$("#graph_product_wise").hide();
$("#graph_customer_wise").hide();
</script>