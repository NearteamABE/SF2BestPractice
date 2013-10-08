var chart2Data = [
{
    jour:"lun",
    visites:2400
},
{
    jour:"mar",
    visites:1894
},
{
    jour:"mer",
    visites:3221
},
{
    jour:"jeu",
    visites:2104
},
{
    jour:"ven",
    visites:3406
},
{
    jour:"sam",
    visites:3298
},
{
    jour:"dim",
    visites:3500
}];

var chart3Data = [
{
    pays:"US",
    visits:9252
},
{
    pays:"CH",
    visits:1882
},
{
    pays:"JP",
    visits:1809
},
{
    pays:"DE",
    visits:1322
},
{
    pays:"UK",
    visits:1122
},
{
    pays:"FR",
    visits:1114
},
{
    pays:"IN",
    visits:984
},
{
    pays:"SP",
    visits:711
}];

var chart4Data = [
{
    pays:"CR",
    litres:156.90
},
{
    pays:"IR",
    litres:131.10
},
{
    pays:"DE",
    litres:115.80
},
{
    pays:"AU",
    litres:109.90
},
{
    pays:"FR",
    litres:108.30
},
{
    pays:"UK",
    litres:99.00
},
{
    pays:"BE",
    litres:93.00
}];

var chart5Data = [
{
    date:new Date(2011,11,1),
    value:10
},
{
    date:new Date(2011,11,2),
    value:15
},
{
    date:new Date(2011,11,3),
    value:13
},
{
    date:new Date(2011,11,4),
    value:17
},
{
    date:new Date(2011,11,5),
    value:15
},
{
    date:new Date(2011,11,6),
    value:21
},
{
    date:new Date(2011,11,7),
    value:19
},
{
    date:new Date(2011,11,8),
    value:24
},
{
    date:new Date(2011,11,9),
    value:18
},
{
    date:new Date(2011,11,10),
    value:31
},];

//Annual chart -- columns
//*******************************************************************
window.onload = function() 
{
    alert("sahaw");
    //Hebdo chart -- columns
    //*******************************************************************
    var chart2 = new AmCharts.AmSerialChart();
    chart2.dataProvider = chart2Data;
    chart2.categoryField = "jour";
    chart2.startDuration = 0.8;
    chart2.columnWidth = 0.9;
    chart2.columnSpacing = 2;
    chart2.marginLeft = 0;
    chart2.marginTop = 0;
    chart2.plotAreaBorderAlpha = 0;
    chart2.numberFormatter = {
        precision:-1, 
        decimalSeparator:'.', 
        thousandsSeparator:' '
    };
    chart2.rotate = false;
    chart2.categoryAxis.labelsEnabled = false;

    var balloon = chart2.balloon;
    balloon.adjustBorderColor = true;
    balloon.color = "#FFFFFF";
    balloon.cornerRadius = 2;
    balloon.borderAlpha = 0;
    balloon.fillColor = "#222222";

    var graph2 = new AmCharts.AmGraph();
    graph2.valueField = "visites";
    graph2.type = "column";
    graph2.lineAlpha = 0;
    graph2.fillAlphas = 1;
    graph2.title = "MyGraph";
    graph2.lineColor = "#CCCCCC";
    graph2.balloonText = "[[category]]: [[value]]";
    chart2.addGraph(graph2);

    var valAxis2 = new AmCharts.ValueAxis();
    valAxis2.stackType = "none";
    valAxis2.gridAlpha = 0;
    valAxis2.axisAlpha = 0;
    valAxis2.color = "#FFFFFF";
    chart2.addValueAxis(valAxis2);

    var catAxis2 = chart2.categoryAxis;
    catAxis2.gridAlpha = 0;
    catAxis2.axisAlpha = 0;
    catAxis2.color = "#FFFFFF";
    catAxis2.gridCount = chart2Data.length;
    catAxis2.gridPosition = "start";

    chart2.write("weekchart");

    //3D pie chart
    //*******************************************************************
    var chart3 = new AmCharts.AmPieChart();
    chart3.dataProvider = chart3Data;
    chart3.titleField = "pays";
    chart3.valueField = "visits";
    chart3.depth3D = 0;
    chart3.angle = 0;
    chart3.innerRadius = "5%";
    chart3.startDuration = 1;
    chart3.labelsEnabled = false;
    chart3.balloonText = "[[title]] [[value]]";
    chart3.numberFormatter = {
        precision:-1, 
        decimalSeparator:'.', 
        thousandsSeparator:' '
    };
    chart3.write("3dpiechart");

    //Flat pie chart
    //*******************************************************************
    var chart4 = new AmCharts.AmPieChart();
    chart4.dataProvider = chart4Data;
    chart4.titleField = "pays";
    chart4.valueField = "litres";
    chart4.depth3D = 0;
    chart4.angle = 0;
    chart4.innerRadius = "20%";
    chart4.startDuration = 1;
    chart4.labelsEnabled = false;
    chart4.balloonText = "[[title]] [[value]]";
    chart4.numberFormatter = {
        precision:-1, 
        decimalSeparator:'.', 
        thousandsSeparator:' '
    };
    chart4.write("piechart");

    //Line chart- area
    //*******************************************************************
    var chart5 = new AmCharts.AmSerialChart();
    chart5.dataProvider = chart5Data;
    chart5.pathToImages = pathToimg;
    chart5.categoryField = "date";
    chart5.startDuration = 1;
    chart5.categoryAxis.labelsEnabled = false;
    chart5.width = "100%";

    var catAxis5 = chart5.categoryAxis;
    catAxis5.parseDates = true;
    catAxis5.gridAlpha = 0;
    catAxis5.tickLength = 0;
    catAxis5.startOnAxis = true;
    catAxis5.equalSpacing = true;
    //catAxis5.dateFormats = "{period:'DD', format:'DD MM YYYY'}";

    var valueAxis5 = new AmCharts.ValueAxis();
    valueAxis5.dashLength = 1;
    valueAxis5.axisAlpha = 0;
    valueAxis5.labelsEnabled = false;
    chart5.addValueAxis(valueAxis5);

    var graph5 = new AmCharts.AmGraph();
    graph5.valueField = "value";
    graph5.type = "smoothedLine";
    graph5.lineColor = "#0A74AF";
    graph5.fillColors = "#2F9CDD";
    graph5.fillAlphas = 0.6;
    graph5.bulletSize = 14;
    chart5.labelsEnabled = false;
    chart5.addGraph(graph5);

    var chartCursor5 = new AmCharts.ChartCursor();
    chart5.addChartCursor(chartCursor5);

    chart5.write("linechart");

}