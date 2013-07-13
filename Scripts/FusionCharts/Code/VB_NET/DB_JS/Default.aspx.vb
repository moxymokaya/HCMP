Imports DataConnection
Imports InfoSoftGlobal
Imports System.Text

Partial Class DB_JS_Default
    Inherits System.Web.UI.Page


    'In this example, we show a combination of database + JavaScript rendering using FusionCharts.
    'The entire app (page) can be summarized as under. This app shows the break-down
    'of factory wise output generated. In a pie chart, we first show the sum of quantity
    'generated by each factory. These pie slices, when clicked would show detailed date-wise
    'output of that factory.
    'The XML data for the pie chart is fully created in ASP.NET at run-time. ASP.NET interacts
    'with the database and creates the XML for this.
    'Now, for the column chart (date-wise output report), we do not submit request to the server.
    'Instead we store the data for the factories in JavaScript arrays. These JavaScript
    'arrays are rendered by our ASP.NET Code (at run-time). We also have a few defined JavaScript
    'functions which react to the click event of pie slice.
    'We've used an Access database which is present in ../DB/FactoryDB.mdb. 
    'It just contains two tables, which are linked to each other. 
    'Before the page is rendered, we need to connect to the database and get the
    'data, as we'll need to convert this data into JavaScript variables.
    Public Function GetScript() As String
        'String to store JavaScript variables
        Dim jsVarString As New StringBuilder()

        'Generate SQL querystring to get all factory Ids
        Dim factoryQuery As String = "select FactoryId from Factory_Master"
        'Sets JavaScript Array Index
        Dim indexCount As Integer = 0

        'Create a table to store factoryIds
        Dim oRs As New DbConn(factoryQuery)

        'Iterate through each record 
        While oRs.ReadData.Read()

            indexCount = indexCount + 1

            'Build JavaScript : Create a new JavaScript Array 
            jsVarString.Append("" & vbTab & vbTab & " data[" & indexCount.ToString() & "] = new Array();" & Environment.NewLine)

            'Create an SQL Query for the current FactoryId
            Dim outputQuery As String = "select DatePro, Quantity from Factory_Output where FactoryId=" & oRs.ReadData("FactoryId").ToString & " order by DatePro Asc"

            'Create a table storing detailed Factory Data 
            Dim oRs1 As New DbConn(outputQuery)

            'Iterate Through records
            While oRs1.ReadData.Read()
                'Build JavaScript : Push Factory Data into JavaScript Array
                'Convert date into specific dd/MM format
                jsVarString.Append("" & vbTab & vbTab & " data[" & indexCount.ToString & "].push(new Array('" & Convert.ToDateTime(oRs1.ReadData("DatePro")).ToString("dd/MM") & "'," & oRs1.ReadData("Quantity").ToString & "));" & Environment.NewLine)

            End While
            oRs1.ReadData.Close()

        End While
        oRs.ReadData.Close()

        'Returns JavaScript variables
        Return jsVarString.ToString()
    End Function

    Public Function GetFactorySummayChartHtml() As String
        'xmlData will be used to store the entire XML document generated
        Dim xmlData As New StringBuilder()
        'Generate the chart element
        xmlData.Append("<chart caption='Factory Output report' subCaption='By Quantity' pieSliceDepth='30' showBorder='1' formatNumberScale='0' numberSuffix=' Units'>")

        'create recordset to get details for the factories
        Dim factoryQuery As String = "select a.FactoryId, a.FactoryName, sum(b.Quantity) as TotQ from .Factory_Master a, Factory_Output b where a.FactoryId=b.FactoryID group by a.FactoryId, a.FactoryName"
        Dim oRs As New DbConn(factoryQuery)

        'Iterate through each record
        While oRs.ReadData.Read()
            'Generate <set name='..' value='..' link='...'/>		
            'The link causes drill-down by calling (here) a JavaScript function
            'The function is passed the Factory id
            'The function updates the second chart
            xmlData.Append("<set label='" & oRs.ReadData("FactoryName").ToString() & "' value='" & oRs.ReadData("TotQ").ToString & "'link='JavaScript:updateChart(" & oRs.ReadData("FactoryId").ToString() & ")' />")
        End While
        oRs.ReadData.Close()

        'Close chart element
        xmlData.Append("</chart>")

        'Create the chart - Pie 3D Chart with data from xmlData
        Return FusionCharts.RenderChart("../FusionCharts/Pie3D.swf", "", xmlData.ToString(), "FactorySum", "500", "250", False, True)

    End Function

    Public Function GetFactoryDetailedChartHtml() As String
        'Column 2D Chart with changed "No data to display" message
        'We initialize the chart with <chart></chart>
        Return FusionCharts.RenderChart("../FusionCharts/Column2D.swf?ChartNoDataText=Please select a factory from pie chart above to view " & "detailed data.", "", "<chart></chart>", "FactoryDetailed", "600", "250", False, True)
    End Function


    Protected Sub Page_Load(ByVal sender As Object, ByVal e As System.EventArgs) Handles Me.Load

        Literal1.Text = GetFactorySummayChartHtml()
        Literal2.Text = GetFactoryDetailedChartHtml()
    End Sub
End Class