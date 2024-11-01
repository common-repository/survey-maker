(function($){
    'use strict';
    $(document).ready(function(){



        // Survey per answer count 
        var perAnswerData = SurveyChartData.perAnswerCount;

        $.each(perAnswerData, function(){
            switch( this.question_type ){
                case "radio":
                    forRadioType( this );
                break;
                case "checkbox":
                    forCheckboxType( this );
                break;
                case "select":
                    forRadioType( this );
                break;
            }
        });


        function forRadioType( item ){
            var questionId = item.question_id;
            var dataTypes = [['Answers', 'Percent']];
            for (var key in item.answers) {
                dataTypes.push([
                    item.answerTitles[key] + '', item.answers[key]
                ]);
            }
            google.charts.load('current', {'packages':['corechart']});
            google.charts.setOnLoadCallback(drawChart);
            
            function drawChart() {

                var data = google.visualization.arrayToDataTable(dataTypes);
                var options = {
                    // height: 300,
                    fontSize: 16,
                    chartArea: { 
                        width: '80%',
                        height: '80%'
                    }
                };

                var chart = new google.visualization.PieChart( document.getElementById( 'survey_answer_chart_' + questionId ) );

                chart.draw(data, options);
            }
        }
        
        function forCheckboxType( item ){
            var questionId = item.question_id;
            var dataTypes = [['Answers', 'Count']];
            for (var key in item.answers) {
                dataTypes.push([
                    item.answerTitles[key] + '', item.answers[key]
                ]);
            }

            google.charts.load('current', {packages: ['corechart', 'bar']});
            google.charts.setOnLoadCallback(drawBasic);

            function drawBasic() {

                var data = google.visualization.arrayToDataTable(dataTypes);
                var groupData = google.visualization.data.group(
                    data,
                    [{column: 0, modifier: function () {return 'total'}, type:'string'}],
                    [{column: 1, aggregation: google.visualization.data.sum, type: 'number'}]
                );
                
                var formatPercent = new google.visualization.NumberFormat({
                    pattern: '#%'
                });
            
                var formatShort = new google.visualization.NumberFormat({
                    pattern: 'short'
                });
            
                var view = new google.visualization.DataView(data);
                view.setColumns([0, 1, {
                    calc: function (dt, row) {
                        var amount =  formatShort.formatValue(dt.getValue(row, 1));
                        var percent = formatPercent.formatValue(dt.getValue(row, 1) / groupData.getValue(0, 1));
                        return amount + ' (' + percent + ')';
                    },
                    type: 'string',
                    role: 'annotation'
                }]);
            
                var options = {
                    width: 700,
                    height: 250,
                    fontSize: 14,
                    chartArea: { 
                        width: '50%',
                    },
                    annotations: {
                        alwaysOutside: true
                    },
                    bars: 'horizontal',
                    bar: { groupWidth: "50%" }
                };

                var chart = new google.visualization.BarChart( document.getElementById( 'survey_answer_chart_' + questionId ) );

                chart.draw(view, options);
            }
        }

        // AV Google charts
        $(document).find('.nav-tab').on('click', function(e) {
            var contValue = $('div#statistics').css('display');
            if (this.getAttribute('href') == '#statistics' || contValue == 'block') {

                //Reports count per day
                var perData = SurveyChartData.countPerDayData;                
                for (var l = 0; l < perData.length; l++) {
                    perData[l] = new Array(
                        new Date(
                            perData[l][0]
                        ),
                        perData[l][1]
                    );
                }
                
                google.charts.load('current', {
                  packages: ['corechart']
                }).then(function () {
                    var data = new google.visualization.DataTable();
                    data.addColumn('date', 'Date');
                    data.addColumn('number', 'Count');
                    
                    data.addRows(perData);

                    var populationRange = data.getColumnRange(1);

                    var logOptions = {
                        // title: '',
                        // legend: 'none',
                        width: 700,
                        height: 300,
                        fontSize: 14,
                        hAxis: {
                            title: 'Date',
                            format: 'MMM d',
                            gridlines: {count: 15}
                        },
                        vAxis: {
                            title: 'Count'
                        }
                    };

                    var logChart = new google.visualization.LineChart(document.getElementById('survey_chart1_div'));
                    logChart.draw(data, logOptions);
                });

                // Survey passed users
                var userCount = SurveyChartData.usersCount;
                var dataTypes = [['Users', 'Percent']];

                if(parseInt(userCount.guests) !== 0){
                    dataTypes.push([
                        "Guests", parseInt(userCount.guests)
                    ]);
                }
                    
                if(parseInt(userCount.loggedIn) !== 0){
                    dataTypes.push([
                        userCount.userRoles[0].type, parseInt(userCount.userRoles[0].percent)
                    ]);
                }

                google.charts.load('current', {'packages':['corechart']});
                google.charts.setOnLoadCallback(drawChart);

                function drawChart() {

                    var data = google.visualization.arrayToDataTable(dataTypes);

                    var options = {
                      // title: 'My Daily Activities'
                        width: 700,
                        height: 300,
                        fontSize: 16,
                        chartArea: { 
                            width: '80%',
                            height: '80%',
                        }
                    };

                    var chart = new google.visualization.PieChart(document.getElementById('survey_chart2_div'));

                    chart.draw(data, options);
                }
            }
        });
    });
})(jQuery);