(function ($) {
"use strict";
var base_url = $("#base_url").val();

var segment = $("#segment").val();
var language = $("#language").val();
/*-------------------------
     * Dynamic bar chart Data
     ------------------------*/
    var chartColors = {
        gray: '#e4e4e4',
        green: '#37a000'
    };

    var randomScalingFactor = function () {
        return (Math.random() > 0.5 ? 1.0 : 1.0) * Math.round(Math.random() * 100);
    };

    // draws a rectangle with a rounded top
    Chart.helpers.drawRoundedTopRectangle = function (ctx, x, y, width, height, radius) {
        ctx.beginPath();
        ctx.moveTo(x + radius, y);
        // top right corner
        ctx.lineTo(x + width - radius, y);
        ctx.quadraticCurveTo(x + width, y, x + width, y + radius);
        // bottom right	corner
        ctx.lineTo(x + width, y + height);
        // bottom left corner
        ctx.lineTo(x, y + height);
        // top left	
        ctx.lineTo(x, y + radius);
        ctx.quadraticCurveTo(x, y, x + radius, y);
        ctx.closePath();
    };

    Chart.elements.RoundedTopRectangle = Chart.elements.Rectangle.extend({
        draw: function () {
            var ctx = this._chart.ctx;
            var vm = this._view;
            var left, right, top, bottom, signX, signY, borderSkipped;
            var borderWidth = vm.borderWidth;

            if (!vm.horizontal) {
                // bar
                left = vm.x - vm.width / 2;
                right = vm.x + vm.width / 2;
                top = vm.y;
                bottom = vm.base;
                signX = 1;
                signY = bottom > top ? 1 : -1;
                borderSkipped = vm.borderSkipped || 'bottom';
            } else {
                // horizontal bar
                left = vm.base;
                right = vm.x;
                top = vm.y - vm.height / 2;
                bottom = vm.y + vm.height / 2;
                signX = right > left ? 1 : -1;
                signY = 1;
                borderSkipped = vm.borderSkipped || 'left';
            }

            // Canvas doesn't allow us to stroke inside the width so we can
            // adjust the sizes to fit if we're setting a stroke on the line
            if (borderWidth) {
                // borderWidth shold be less than bar width and bar height.
                var barSize = Math.min(Math.abs(left - right), Math.abs(top - bottom));
                borderWidth = borderWidth > barSize ? barSize : borderWidth;
                var halfStroke = borderWidth / 2;
                // Adjust borderWidth when bar top position is near vm.base(zero).
                var borderLeft = left + (borderSkipped !== 'left' ? halfStroke * signX : 0);
                var borderRight = right + (borderSkipped !== 'right' ? -halfStroke * signX : 0);
                var borderTop = top + (borderSkipped !== 'top' ? halfStroke * signY : 0);
                var borderBottom = bottom + (borderSkipped !== 'bottom' ? -halfStroke * signY : 0);
                // not become a vertical line?
                if (borderLeft !== borderRight) {
                    top = borderTop;
                    bottom = borderBottom;
                }
                // not become a horizontal line?
                if (borderTop !== borderBottom) {
                    left = borderLeft;
                    right = borderRight;
                }
            }

            // calculate the bar width and roundess
            var barWidth = Math.abs(left - right);
            var roundness = this._chart.config.options.barRoundness || 0.5;
            var radius = barWidth * roundness * 0.5;

            // keep track of the original top of the bar
            var prevTop = top;

            // move the top down so there is room to draw the rounded top
            top = prevTop + radius;
            var barRadius = top - prevTop;

            ctx.beginPath();
            ctx.fillStyle = vm.backgroundColor;
            ctx.strokeStyle = vm.borderColor;
            ctx.lineWidth = borderWidth;

            // draw the rounded top rectangle
            Chart.helpers.drawRoundedTopRectangle(ctx, left, (top - barRadius + 1), barWidth, bottom - prevTop, barRadius);

            ctx.fill();
            if (borderWidth) {
                ctx.stroke();
            }

            // restore the original top value so tooltips and scales still work
            top = prevTop;
        },
    });

    Chart.defaults.roundedBar = Chart.helpers.clone(Chart.defaults.bar);

    Chart.controllers.roundedBar = Chart.controllers.bar.extend({
        dataElementType: Chart.elements.RoundedTopRectangle
    });

    
    //Dynamic Pie Charts
    
        

    if($('#barChart').length){
        $.getJSON(base_url+'/internal_api/barchartdata', function(data){
            var ctx = document.getElementById("barChart");
            window.barChart1 = new Chart(ctx, {
                type: 'roundedBar',
                data: {
                    labels: data.months,
                    datasets: [
                        {
                            label: "Total Minted NFTs",
                            backgroundColor: chartColors.green,
                            data: data.total
                        },
                         
                    ]
                },
                options: {
            legend: false,
            responsive: true,
            barRoundness: 1,
            scales: {
                yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            padding: 10,
                        },
                        gridLines: {
                            borderDash: [2],
                            borderDashOffset: [2],
                            drawBorder: false,
                            drawTicks: false,

                        },

                    }],

                xAxes: [{
                        maxBarThickness: 10,
                        gridLines: {
                            lineWidth: [0],
                            drawBorder: false,
                            drawOnChartArea: false,
                            drawTicks: false
                        },
                        ticks: {
                            padding: 20
                        },

                    }],
            }
        }
            });
        });
    }

    $(document).on("change","#nfts_year", function(event) {
        event.preventDefault();
        var inputdata = $("#nfts_year").val();
        $.getJSON(base_url+'/internal_api/barchartdata/'+inputdata, function(data){
            
            var ctx = document.getElementById("barChart");
            if(window.barChart2 != undefined)
                {
                    window.barChart2.destroy();
                }
            window.barChart2 = new Chart(ctx, {
                type: 'roundedBar',
                data: {
                    labels: data.months,
                    datasets: [
                        {
                            label: "Total Minted NFTs",
                            backgroundColor: chartColors.green,
                            data: data.total
                        },
                         
                    ]
                },
                options: {
                    legend: false,
                    responsive: true,
                    barRoundness: 1,
                    scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            padding: 10
                        },
                        gridLines: {
                            borderDash: [2],
                            borderDashOffset: [2],
                            drawBorder: false,
                            drawTicks: false,

                        },

                    }],

                xAxes: [{
                        maxBarThickness: 10,
                        gridLines: {
                            lineWidth: [0],
                            drawBorder: false,
                            drawOnChartArea: false,
                            drawTicks: false
                        },
                        ticks: {
                            padding: 20
                        },

                    }],
            }
        }
            });
            window.barChart1.destroy();
        });
    });

 
    var ctx = document.getElementById("pieChart");
    if($('#pieChart').length){
        $.getJSON(base_url+'/internal_api/getpiechartdata', function(data){
            
            var myChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    datasets: [{
                            data: data.data,
                            backgroundColor: data.color,
                            hoverBackgroundColor: data.color

                        }],
                    labels: data.level
                },
                options: {
                    legend: false,
                    responsive: true
                }
            });
        });
    }
 
    $(document).on("change", "#pie_year", function(event) {

        var year = $("#pie_year").val();
        $.getJSON(base_url+'/internal_api/getpiechartdata/'+year, function(data){
            
            var myChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    datasets: [{
                            data: data.data,
                            backgroundColor: data.color,
                            hoverBackgroundColor: data.color

                        }],
                    labels: data.level
                },
                options: {
                    legend: false,
                    responsive: true
                }
            });
        });

    });


}(jQuery));