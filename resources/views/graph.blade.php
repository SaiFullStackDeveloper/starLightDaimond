<script>
    const ctx = document.getElementById('myChart');


const options = {
  layout: { autoPadding: true },
  hover: { intersect: false },
  // borderWidth: 100,
  backdropPadding: 0,
  padding: 0,
  plugins: {
    legend: {
      display: true,
    },
    tooltip: {
      caretPadding: 10,
      caretPosition: 'right',
      caretX: 0,
      caretY: 0,
      intersect: false,
      mode: 'index',
      // xAlign: 'right',
      yAlign: 'center',
      position: 'average',
      // callbacks: {
      //   //This removes the tooltip title
      //   // title: function () {},
      //   label: ({ raw }) => {
      //     return raw
      //   },
      // },
      //this removes legend color
      displayColors: false,
      padding: 3,
      pointHitRadius: 5,
      pointRadius: 1,
      caretSize: 10,
      backgroundColor: 'rgba(255,255,255,.9)',
      // borderColor: `red`,
      borderWidth: 1,
      bodyFont: {
        family: 'Inter',
        size: 12,
      },
      bodyColor: '#303030',
      titleFont: {
        family: 'Inter',
      },
      titleColor: 'rgba(0,0,0,0.6)',
    },
  },
  scales: {
    y: {
      ticks: {
        display: true,
      },
      grid: {
        drawBorder: false,
        borderWidth: 0,
        drawTicks: false,
        color: 'transparent',
        width: 0,
        backdropPadding: 0,
      },
      drawBorder: false,
      drawTicks: false,
    },
    x: {
      ticks: {
        display: true,
      },
      grid: {
        drawBorder: false,
        borderWidth: 0,
        drawTicks: false,
        display: false,
      },
    },
  },
  responsive: true,
  maintainAspectRatio: false,
}

const labels = ["JAN", "FEB", "MAR", "APR", "MAY", "JUN", "JUL", "AUG", "SEP", "OCT", "NOV", "DEC"]

const data = {
  labels,
  datasets: [
    {
      label: 'Sum of Total Gross Weight',
      data: [29, 58, 30, 40, 5, 35, 0, 18, 9, 30, 45, 38],
      backgroundColor: '#006CFF',
      minBarLength: 50,
      borderRadius: 100,
      borderSkipped: false,
    },
    {
      label: 'Sum of Approx Gms',
      data: [25, 10, 33, 46, 5, 60, 0, 22, 9, 80, 14, 44],
      backgroundColor: '#9680FF',
      minBarLength: 50,
      borderRadius: 100,
      borderSkipped: false,
    },
  ],
}


const myChart = new Chart(ctx, {
    type: 'bar',
    data,
    options,
});








// 22222222222


// const options = {
//   layout: { autoPadding: true },
//   hover: { intersect: false },
//   // borderWidth: 100,
//   backdropPadding: 0,
//   padding: 0,
//   plugins: {
//     legend: {
//       display: true,
//     },
//     tooltip: {
//       caretPadding: 10,
//       caretPosition: 'right',
//       caretX: 0,
//       caretY: 0,
//       intersect: false,
//       mode: 'index',
//       // xAlign: 'right',
//       yAlign: 'center',
//       position: 'average',
//       // callbacks: {
//       //   //This removes the tooltip title
//       //   // title: function () {},
//       //   label: ({ raw }) => {
//       //     return raw
//       //   },
//       // },
//       //this removes legend color
//       displayColors: false,
//       padding: 3,
//       pointHitRadius: 5,
//       pointRadius: 1,
//       caretSize: 10,
//       backgroundColor: 'rgba(255,255,255,.9)',
//       // borderColor: `red`,
//       borderWidth: 1,
//       bodyFont: {
//         family: 'Inter',
//         size: 12,
//       },
//       bodyColor: '#303030',
//       titleFont: {
//         family: 'Inter',
//       },
//       titleColor: 'rgba(0,0,0,0.6)',
//     },
//   },
//   scales: {
//     y: {
//       ticks: {
//         display: true,
//       },
//       grid: {
//         drawBorder: false,
//         borderWidth: 0,
//         drawTicks: false,
//         color: 'transparent',
//         width: 0,
//         backdropPadding: 0,
//       },
//       drawBorder: false,
//       drawTicks: false,
//     },
//     x: {
//       ticks: {
//         display: true,
//       },
//       grid: {
//         drawBorder: false,
//         borderWidth: 0,
//         drawTicks: false,
//         display: false,
//       },
//     },
//   },
//   responsive: true,
//   maintainAspectRatio: false,
// }

// const labels = ["JAN", "FEB", "MAR", "APR", "MAY", "JUN", "JUL", "AUG", "SEP", "OCT", "NOV", "DEC"]

// const data = {
//   labels,
//   datasets: [
//     {
//       label: 'Sum of Total Gross Weight',
//       data: [29, 58, 30, 40, 5, 35, 0, 18, 9, 30, 45, 38],
//       backgroundColor: '#006CFF',
//       minBarLength: 50,
//       borderRadius: 100,
//       borderSkipped: false,
//     },
//     {
//       label: 'Sum of Approx Gms',
//       data: [25, 10, 33, 46, 5, 60, 0, 22, 9, 80, 14, 44],
//       backgroundColor: '#9680FF',
//       minBarLength: 50,
//       borderRadius: 100,
//       borderSkipped: false,
//     },
//   ],
// }


// const myChart2 = new Chart(ctx2, {
//     type: 'bar',
//     data,
//     options,
// });






new Chart(document.querySelector('#myChart2').getContext('2d'), {
        type: 'bar',
        data: {
            labels: {!! $grap2_lavel !!},
            datasets: [{
                label: '',
                data: {{$grap2_val}},
                fill: true,
                borderRadius: 100,
                borderSkipped: false,
                borderColor: '#fff',
                backgroundColor: '#5eb8ff',                 

                datalabels: {
                    display: false
                }
            }]
                },
                options:{
                  scales: {
          x: {
            grid: {
              display: false,
              drawOnChartArea:false
            }
          },
          y: {
            grid: {
              display: false,
              drawOnChartArea:false,
            }
          }
        }
        }
    });


new Chart(document.querySelector('#myChart3').getContext('2d'), {
        type: "doughnut",
        data: {
            datasets: [{
                label: 'Orders',
                data: {!! $karrat_val !!},
                fill: true,
                borderRadius: 0,
                indexLabelFontSize: 17,
                indexLabel: "{label} - #percent%",
                toolTipContent: "<b>{label}:</b> {y} (#percent%)",
                borderColor: '#fff',
                backgroundColor : [  "#FFC300", "#FF5733", "#C70039", "#900C3F", "#581845",  "#00FFFF", "#00BFFF", "#008080", "#2E8B57", "#FFA07A",  "#FF7F50", "#FF6347", "#DC143C", "#8B0000", "#4B0082",  "#8A2BE2", "#4B008A", "#483D8B", "#00CED1", "#1E90FF",  "#ADD8E6", "#F08080", "#FA8072", "#E9967A", "#FFC0CB",  "#FF69B4", "#FF1493", "#C71585", "#9400D3", "#9932CC",  "#8B008B", "#800080", "#4F4F4F", "#696969", "#808080",  "#A9A9A9", "#C0C0C0", "#D3D3D3", "#FFFFFF", "#000000",  "#FFDAB9", "#FFE4B5", "#F5DEB3", "#FFF8DC", "#F5F5DC",  "#FAEBD7", "#FFF0F5", "#E6E6FA", "#F8F8FF", "#F0F8FF",  "#FFFAFA", "#F0FFF0", "#FFFACD", "#FFEFD5", "#FFF5EE",  "#F5FFFA", "#FFFFF0", "#FFF0F5", "#D8BFD8", "#DA70D6",  "#EE82EE", "#FF00FF", "#BA55D3", "#9370DB", "#8B008B",  "#6A5ACD", "#483D8B", "#7B68EE", "#191970", "#000080",  "#4169E1", "#6495ED", "#00FFFF", "#008B8B", "#20B2AA",  "#00FF7F", "#32CD32", "#9ACD32", "#ADFF2F", "#7CFC00",  "#556B2F", "#808000", "#6B8E23", "#BDB76B", "#F0E68C",  "#FFD700", "#FFA500", "#FF8C00", "#FF4500", "#B22222",  "#8B0000", "#CD5C5C", "#DC143C", "#FF69B4", "#FF1493"],
                 

                datalabels: {
                    display: false
                }
            }]
                },

        //         options:{
        //           scales: {
        //   x: {
        //     grid: {
        //       display: false,
        //       drawOnChartArea:false
        //     }
        //   },
        //   y: {
        //     grid: {
        //       display: false,
        //       drawOnChartArea:false,
        //     }
        //   }
        // }
        // }
    });


new Chart(document.querySelector('#myChart4').getContext('2d'), {
        type: "doughnut",
        data: {
            datasets: [{
                label: 'Orders',
                data: {!! $customer_order_val !!},
                fill: true,
                borderRadius: 0,
                indexLabelFontSize: 17,
                indexLabel: "{label} - #percent%",
                toolTipContent: "<b>{label}:</b> {y} (#percent%)",
                borderColor: '#fff',
                backgroundColor : [  "#FFC300", "#FF5733", "#C70039", "#900C3F", "#581845",  "#00FFFF", "#00BFFF", "#008080", "#2E8B57", "#FFA07A",  "#FF7F50", "#FF6347", "#DC143C", "#8B0000", "#4B0082",  "#8A2BE2", "#4B008A", "#483D8B", "#00CED1", "#1E90FF",  "#ADD8E6", "#F08080", "#FA8072", "#E9967A", "#FFC0CB",  "#FF69B4", "#FF1493", "#C71585", "#9400D3", "#9932CC",  "#8B008B", "#800080", "#4F4F4F", "#696969", "#808080",  "#A9A9A9", "#C0C0C0", "#D3D3D3", "#FFFFFF", "#000000",  "#FFDAB9", "#FFE4B5", "#F5DEB3", "#FFF8DC", "#F5F5DC",  "#FAEBD7", "#FFF0F5", "#E6E6FA", "#F8F8FF", "#F0F8FF",  "#FFFAFA", "#F0FFF0", "#FFFACD", "#FFEFD5", "#FFF5EE",  "#F5FFFA", "#FFFFF0", "#FFF0F5", "#D8BFD8", "#DA70D6",  "#EE82EE", "#FF00FF", "#BA55D3", "#9370DB", "#8B008B",  "#6A5ACD", "#483D8B", "#7B68EE", "#191970", "#000080",  "#4169E1", "#6495ED", "#00FFFF", "#008B8B", "#20B2AA",  "#00FF7F", "#32CD32", "#9ACD32", "#ADFF2F", "#7CFC00",  "#556B2F", "#808000", "#6B8E23", "#BDB76B", "#F0E68C",  "#FFD700", "#FFA500", "#FF8C00", "#FF4500", "#B22222",  "#8B0000", "#CD5C5C", "#DC143C", "#FF69B4", "#FF1493"],
                 

                datalabels: {
                    display: false
                }
            }]
                },

        //         options:{
        //           scales: {
        //   x: {
        //     grid: {
        //       display: false,
        //       drawOnChartArea:false
        //     }
        //   },
        //   y: {
        //     grid: {
        //       display: false,
        //       drawOnChartArea:false,
        //     }
        //   }
        // }
        // }
    });



new Chart(document.querySelector('#myChart5').getContext('2d'), {
        type: 'bar',
        data: {
            labels: ["Sai Gold", "Ananya Jewels", "Bijou Raayan", "Rohini Diamonds", "Shree Diamonds", "Marlecha Diamonds", "NSSJ", "Panchrathnam"],
            datasets: [{
                label: '',
                data: [32,28,23,61,73,34,46,42],
                fill: true,
                borderRadius: 10,
                borderSkipped: false,
                borderColor: '#fff',
                backgroundColor: '#006cff5c',                 

                datalabels: {
                    display: false
                }
            },
            {
                label: '',
                data: [10,40,30,50,80,10,30,20],
                fill: true,
                borderRadius: 10,
                borderSkipped: false,
                borderColor: '#fff',
                backgroundColor: '#006cff40',
                tension:0.4,                 
                type: 'line',
                datalabels: {
                    display: false
                }
            }]
                },
                options:{
                  scales: {
          x: {
            grid: {
              display: false,
              drawOnChartArea:false
            }
          },
          y: {
            grid: {
              display: false,
              drawOnChartArea:false,
            }
          }
        }
        }
    });



new Chart(document.querySelector('#myChart6').getContext('2d'), {
        type: 'bar',
        data: {
            labels: ["Ring", "Earrings", "Nose Pins", "Gold", "Braclets", "Chains", "Marlecha Diamonds"],
            datasets: [{
                label: '',
                data: [32,26,64,64,36,42,58],
                fill: true,
                borderRadius: 10,
                borderSkipped: false,
                borderColor: '#fff',
                backgroundColor: '#006cff5c',                 

                datalabels: {
                    display: false
                }
            },
            {
                label: '',
                data: [10,40,30,50,80,10,30,20],
                fill: true,
                borderRadius: 10,
                borderSkipped: false,
                borderColor: '#fff',
                backgroundColor: '#006cff40',
                tension:0.4,                 
                type: 'line',
                datalabels: {
                    display: false
                }
            }]
                },
                options:{
                  scales: {
          x: {
            grid: {
              display: false,
              drawOnChartArea:false
            }
          },
          y: {
            grid: {
              display: false,
              drawOnChartArea:false,
            }
          }
        }
        }
    });

</script>