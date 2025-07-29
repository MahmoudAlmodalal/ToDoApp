$(document).ready(function() {
  "use strict";


  /*used*/
  /*======== 11. DOUGHNUT CHART ========*/
  var doughnut = document.getElementById("doChart");
  if (doughnut !== null) {
    var taskCom = doughnut.getAttribute("task-com");
    var taskUncom = doughnut.getAttribute("task-uncom");
    var taskFailed = doughnut.getAttribute("task-failed");
    var myDoughnutChart = new Chart(doughnut, {
      type: "doughnut",
      data: {
        labels: ["completed", "uncompleted", "Failed"],
        datasets: [
          {
            label: ["completed", "uncompleted", "Failed"],
            data: [ taskCom, taskUncom, taskFailed],
            backgroundColor: ["#4c84ff", "#29cc97", "#8061ef"],
            borderWidth: 1
            // borderColor: ['#4c84ff','#29cc97','#8061ef','#fec402']
            // hoverBorderColor: ['#4c84ff', '#29cc97', '#8061ef', '#fec402']
          }
        ]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        legend: {
          display: false
        },
        cutoutPercentage: 75,
        tooltips: {
          callbacks: {
            title: function(tooltipItem, data) {
              return "Task : " + data["labels"][tooltipItem[0]["index"]];
            },
            label: function(tooltipItem, data) {
              return data["datasets"][0]["data"][tooltipItem["index"]];
            }
          },
          titleFontColor: "#888",
          bodyFontColor: "#555",
          titleFontSize: 12,
          bodyFontSize: 14,
          backgroundColor: "rgba(256,256,256,0.95)",
          displayColors: true,
          borderColor: "rgba(220, 220, 220, 0.9)",
          borderWidth: 2
        }
      }
    });
  }


  /*======== 19. DEVICE - DOUGHNUT CHART ========*/
  var deviceChart = document.getElementById("deviceChart");
  if (deviceChart !== null) {
    var taskCom = deviceChart.getAttribute("task-com");
    var taskUncom = deviceChart.getAttribute("task-uncom");
    var taskFailed = deviceChart.getAttribute("task-failed");
    var mydeviceChart = new Chart(deviceChart, {
      type: "doughnut",
      data: {
        labels: ["Completed", "uncompleted", "Failed"],
        datasets: [
          {
            label: ["Completed", "uncompleted", "Failed"],
            data: [taskCom, taskUncom, taskFailed],
            backgroundColor: [
              "rgba(76, 132, 255, 1)",
              "rgba(76, 132, 255, 0.85)",
              "rgba(76, 132, 255, 0.70)",
            ],
            borderWidth: 1
          }
        ]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        legend: {
          display: false
        },
        cutoutPercentage: 75,
        tooltips: {
          callbacks: {
            title: function(tooltipItem, data) {
              return data["labels"][tooltipItem[0]["index"]];
            },
            label: function(tooltipItem, data) {
              return (
                data["datasets"][0]["data"][tooltipItem["index"]] + " Tasks"
              );
            }
          },

          titleFontColor: "#888",
          bodyFontColor: "#555",
          titleFontSize: 12,
          bodyFontSize: 15,
          backgroundColor: "rgba(256,256,256,0.95)",
          displayColors: true,
          xPadding: 10,
          yPadding: 7,
          borderColor: "rgba(220, 220, 220, 0.9)",
          borderWidth: 2,
          caretSize: 6,
          caretPadding: 5
        }
      }
    });
  }
});
