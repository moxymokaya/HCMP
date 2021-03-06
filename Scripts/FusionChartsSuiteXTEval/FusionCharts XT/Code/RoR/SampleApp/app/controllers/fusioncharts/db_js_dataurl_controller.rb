#This example shows how to generate a pie-chart by retrieving 
#values of the total output quantities produced in factories with their names
#On clicking on a pie-section, the detailed date-wise output quantity
#for that factory is displayed as a chart on the same page.
#In this example, we show a combination of database + JavaScript (dataUrl method)
#rendering using FusionCharts.
#The entire example can be summarized as under. This example shows the break-down
#of factory wise output generated. In a pie chart, we first show the sum of quantity
#generated by each factory. These pie slices, when clicked would show detailed date-wise
#output of that factory. The detailed data would be dynamically pulled by the column
#chart from another page. There are no page refreshes required. Everything
#is done on one single page.
#The XML data for the pie chart is fully created at run-time. 
#Now, for the column chart (date-wise output report), each time we need the data
#we dynamically submit request to the server with the appropriate factoryId. The server
#responds with an XML document, which we accept and update chart at client side.
class Fusioncharts::DbJsDataurlController < ApplicationController
  
    #Default action. Used to show the pie chart
    #Finds the factories
    def default
    
      response.content_type = Mime::HTML
      # Expects a parameter called animate
      @animate_chart = params[:animate]
      if @animate_chart.nil? or @animate_chart.empty?
         # Assigns default values as '1'
         @animate_chart = '1'
     end
    @factories = Fusioncharts::FactoryMaster.find(:all) 
    render :layout=>"common"
    end
    
    #This action will generate a chart to show the detailed information of the selected factory.
    #Expects id as parameter in the request 
    def factory_details
        response.content_type = Mime::XML
        # Get the factoryId from request using params[]
        @factory_id = params[:id]
        factory = Fusioncharts::FactoryMaster. find(@factory_id)
        @factory_output_quantities = factory.factory_output_quantities
    end
    
    def linked_simple
       response.content_type = Mime::HTML
       @factories = Fusioncharts::FactoryMaster.find(:all) 
       #The common layout for this view
       render(:layout => "layouts/common")
    end
        
end