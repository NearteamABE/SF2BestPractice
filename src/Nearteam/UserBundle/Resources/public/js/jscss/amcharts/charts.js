var chart1Data = [
{jour:"01/12/2011",resas:2841},
{jour:"02/12/2011",resas:3028},
{jour:"03/12/2011",resas:3215},
{jour:"04/12/2011",resas:3402},
{jour:"05/12/2011",resas:3776},
{jour:"06/12/2011",resas:3776},
{jour:"07/12/2011",resas:3963},
{jour:"08/12/2011",resas:8077},
{jour:"09/12/2011",resas:4337},
{jour:"10/12/2011",resas:4524},
{jour:"11/12/2011",resas:3589},
{jour:"12/12/2011",resas:4898},
{jour:"13/12/2011",resas:5085},
{jour:"14/12/2011",resas:5272},
{jour:"15/12/2011",resas:5459},
{jour:"16/12/2011",resas:5646},
{jour:"17/12/2011",resas:5833},
{jour:"18/12/2011",resas:6020},
{jour:"19/12/2011",resas:6207},
{jour:"20/12/2011",resas:6394},
{jour:"21/12/2011",resas:6581},
{jour:"22/12/2011",resas:6768},
{jour:"23/12/2011",resas:6955},
{jour:"24/12/2011",resas:7142},
{jour:"25/12/2011",resas:7329},
{jour:"26/12/2011",resas:7516},
{jour:"27/12/2011",resas:7703},
{jour:"28/12/2011",resas:7890},
{jour:"29/12/2011",resas:4150},
{jour:"30/12/2011",resas:8264},
{jour:"31/12/2011",resas:8451}];

var chart2Data = [
{semaine:"S",réservations:2400},
{semaine:"S-1",réservations:1894}]
;

//var chart3Data = [
//{pays:"US",visits:9252},
//{pays:"CH",visits:1882},
//{pays:"JP",visits:1809},
//{pays:"DE",visits:1322},
//{pays:"UK",visits:1122},
//{pays:"FR",visits:1114},
//{pays:"IN",visits:984},
//{pays:"SP",visits:711}];
//
//var chart4Data = [
//{pays:"CR",litres:156.90},
//{pays:"IR",litres:131.10},
//{pays:"DE",litres:115.80},
//{pays:"AU",litres:109.90},
//{pays:"FR",litres:108.30},
//{pays:"UK",litres:99.00},
//{pays:"BE",litres:93.00}];

var chart5Data = [
{date:new Date(2011,11,1),value:10},
{date:new Date(2011,11,2),value:15},
{date:new Date(2011,11,3),value:13},
{date:new Date(2011,11,4),value:17},
{date:new Date(2011,11,5),value:15},
{date:new Date(2011,11,6),value:21},
{date:new Date(2011,11,7),value:19},
{date:new Date(2011,11,8),value:24},
{date:new Date(2011,11,9),value:18},
{date:new Date(2011,11,10),value:31},];

//Annual chart -- columns
//*******************************************************************
window.onload = function() 
{
var chart1 = new AmCharts.AmSerialChart();
chart1.dataProvider = chart1Data;
chart1.categoryField = "jour";
chart1.startDuration = 0.8;
chart1.columnWidth = 0.9;
chart1.columnSpacing = 2;
chart1.marginLeft = 0;
chart1.marginTop = 0;
chart1.plotAreaBorderAlpha = 0;
chart1.numberFormatter = {precision:-1, decimalSeparator:'.', thousandsSeparator:' '};
chart1.rotate = false;
chart1.categoryAxis.labelsEnabled = false;

var balloon = chart1.balloon;
balloon.adjustBorderColor = true;
balloon.color = "#FFFFFF";
balloon.cornerRadius = 2;
balloon.borderAlpha = 0;
balloon.fillColor = "#222222";

var graph1 = new AmCharts.AmGraph();
graph1.title = "resas";
// graph.labelText="[[value]]";
graph1.valueField = "resas";
graph1.type = "column";
graph1.lineAlpha = 0;
graph1.fillAlphas = 0.7;
graph1.lineColor = "#CCCCCC"; //couleur colonnes
graph1.balloonText = "[[category]]: [[value]]";
graph1.title = "Resas mensuelles";
chart1.addGraph(graph1);

var valAxis1 = new AmCharts.ValueAxis();
valAxis1.stackType = "none";
valAxis1.gridAlpha = 0;
valAxis1.axisAlpha = 0;
valAxis1.color = "#FFFFFF";
chart1.addValueAxis(valAxis1);

var catAxis1 = chart1.categoryAxis;
catAxis1.gridAlpha = 0;
catAxis1.axisAlpha = 0;
catAxis1.color = "#FFFFFF";
catAxis1.gridCount = chart1Data.length;
catAxis1.gridPosition = "start";

chart1.write("chartdiv");


//Hebdo chart -- columns
//*******************************************************************
var chart2 = new AmCharts.AmSerialChart();
chart2.dataProvider = chart2Data;
chart2.categoryField = "semaine";
chart2.startDuration = 0.8;
chart2.columnWidth = 0.8;
chart2.columnSpacing = 1;
chart2.marginLeft = 0;
chart2.marginTop = 0;
chart2.plotAreaBorderAlpha = 0;
chart2.numberFormatter = {precision:-1, decimalSeparator:'.', thousandsSeparator:' '};
chart2.rotate = true;

var balloon = chart2.balloon;
balloon.adjustBorderColor = true;
balloon.color = "#FFFFFF";
balloon.cornerRadius = 2;
balloon.borderAlpha = 0;
balloon.fillColor = "#222222";

var graph2 = new AmCharts.AmGraph();
graph2.valueField = "réservations";
graph2.type = "column";
graph2.lineAlpha = 0;
graph2.fillAlphas = 1;
graph2.title = "MyGraph";
graph2.lineColor = "#59BDEF";
graph2.balloonText = "[[category]]: [[value]] réservations";
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
//var chart3 = new AmCharts.AmPieChart();
//chart3.dataProvider = chart3Data;
//chart3.titleField = "pays";
//chart3.valueField = "visits";
//chart3.depth3D = 5;
//chart3.angle = 5;
//chart3.innerRadius = "20%";
//chart3.startDuration = 1;
//chart3.labelsEnabled = false;
//chart3.balloonText = "[[title]] [[value]]";
//chart3.numberFormatter = {precision:-1, decimalSeparator:'.', thousandsSeparator:' '};
//chart3.write("3dpiechart");
//
//Flat pie chart
//*******************************************************************
//var chart4 = new AmCharts.AmPieChart();
//chart4.dataProvider = chart4Data;
//chart4.titleField = "pays";
//chart4.valueField = "litres";
//chart4.depth3D = 0;
//chart4.angle = 0;
//chart4.innerRadius = "20%";
//chart4.startDuration = 1;
//chart4.labelsEnabled = false;
//chart4.balloonText = "[[title]] [[value]]";
//chart4.numberFormatter = {precision:-1, decimalSeparator:'.', thousandsSeparator:' '};
//chart4.write("piechart");

//Line chart- area
//*******************************************************************
var chart5 = new AmCharts.AmSerialChart();
chart5.dataProvider = chart5Data;
//chart5.pathToImages = "img/";
chart5.categoryField = "date";
chart5.startDuration = 1;
chart5.categoryAxis.labelsEnabled = false;
chart5.marginLeft = 0;

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