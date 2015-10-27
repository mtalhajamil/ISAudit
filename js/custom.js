

function toggleFeature(feature)
{
    $.ajax({
        type: "GET",
        url: feature,
        //data: space_id,
        success: function(result){
           alert('Successfully completed operation '+ feature);

        }
    });
};



 
 
 