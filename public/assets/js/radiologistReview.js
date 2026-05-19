const arr_attr = ["id_quality" , "processing", "positioning",
                "exposure", "artifacts", "inspiratory_effort",
                "movement", "anatomical_marker", "others_quality",
                "thoracic_cage", "heart_size_shape", "lung_field",
                "mediastinum_hilar_region", "pleura", "focal_lesion",
                "other_findings", "decision"];

//SET TO DEFAULT STATUS
function setDefault(){
    $('#id_quality').val(false);
    $('#id_quality_true').removeClass('btn-danger');
    $('#id_quality_false').addClass('btn-success');

    $('#processing').val(false);
    $('#processing_true').removeClass('btn-danger');
    $('#processing_false').addClass('btn-success');

    $('#positioning').val(false);
    $('#positioning_true').removeClass('btn-danger');
    $('#positioning_false').addClass('btn-success');

    $('#exposure').val(false);
    $('#exposure_true').removeClass('btn-danger');
    $('#exposure_false').addClass('btn-success');

    $('#artifacts').val(false);
    $('#artifacts_true').removeClass('btn-danger');
    $('#artifacts_false').addClass('btn-success');

    $('#inspiratory_effort').val(false);
    $('#inspiratory_effort_true').removeClass('btn-danger');
    $('#inspiratory_effort_false').addClass('btn-success');

    $('#movement').val(false);
    $('#movement_true').removeClass('btn-danger');
    $('#movement_false').addClass('btn-success');

    $('#anatomical_marker').val(false);
    $('#anatomical_marker_true').removeClass('btn-danger');
    $('#anatomical_marker_false').addClass('btn-success');

    $('#others_quality').val(false);
    $('#others_quality_true').removeClass('btn-danger');
    $('#others_quality_false').addClass('btn-success');

    $('#thoracic_cage').val(false);
    $('#thoracic_cage_true').removeClass('btn-danger');
    $('#thoracic_cage_false').addClass('btn-success');

    $('#heart_size_shape').val(false);
    $('#heart_size_shape_true').removeClass('btn-danger');
    $('#heart_size_shape_false').addClass('btn-success');

    $('#lung_field').val(false);
    $('#lung_field_true').removeClass('btn-danger');
    $('#lung_field_false').addClass('btn-success');

    $('#mediastinum_hilar_region').val(false);
    $('#mediastinum_hilar_region_true').removeClass('btn-danger');
    $('#mediastinum_hilar_region_false').addClass('btn-success');

    $('#pleura').val(false);
    $('#pleura_true').removeClass('btn-danger');
    $('#pleura_false').addClass('btn-success');

    $('#focal_lesion').val(false);
    $('#focal_lesion_true').removeClass('btn-danger');
    $('#focal_lesion_false').addClass('btn-success');

    $('#other_findings').val(false);
    $('#other_findings_true').removeClass('btn-danger');
    $('#other_findings_false').addClass('btn-success');
}

function triggerChange(item, index){
    if(item == 'decision'){
        $("#"+item+"_true").click(function(){
            $("#"+item).val('ABNORMAL');
            $(this).addClass('btn-danger');
            $("#"+item+"_false").removeClass('btn-success');
            $("#"+item+"_retake").removeClass('btn-warning');
        })
        $("#"+item+"_false").click(function(){
            $("#"+item).val('NORMAL');
            $(this).addClass('btn-success');
            $("#"+item+"_true").removeClass('btn-danger');
            $("#"+item+"_retake").removeClass('btn-warning');
        })
        $("#"+item+"_retake").click(function(){
            $("#"+item).val('RETAKE');
            $(this).addClass('btn-warning');
            $("#"+item+"_true").removeClass('btn-danger');
            $("#"+item+"_false").removeClass('btn-success');
        })
    }else{
        $("#"+item+"_true").click(function(){
            $("#"+item).val(true);
            $(this).addClass('btn-danger');
            $("#"+item+"_false").removeClass('btn-success');
            $("#impression").val('');
        })
        $("#"+item+"_false").click(function(){
            $("#"+item).val(false);
            $(this).addClass('btn-success');
            $("#"+item+"_true").removeClass('btn-danger');
        })
    }

}

$("#radiologist_form").validate({
    errorClass: "text-danger",
    ignore:[],
    rules:{
        id_quality: "required",
        id_quality_comment: {
            required: {
                depends : function (){

                if($("#id_quality").val() == 'true'){
                        return true
                }else{
                    return false
                }
            }},
        },
        processing: "required",
        processing_comment: {
            required: {
                depends : function (){

                if($("#processing").val() == 'true'){
                        return true
                }else{
                    return false
                }
            }},
        },
        positioning: "required",
        positioning_comment: {
            required: {
                depends : function (){

                if($("#positioning").val() == 'true'){
                        return true
                }else{
                    return false
                }
            }},
        },
        exposure: "required",
        exposure_comment: {
            required: {
                depends : function (){

                if($("#exposure").val() == 'true'){
                        return true
                }else{
                    return false
                }
            }},
        },
        artifacts: "required",
        artifacts_comment: {
            required: {
                depends : function (){

                if($("#artifacts").val() == 'true'){
                        return true
                }else{
                    return false
                }
            }},
        },
        inspiratory_effort: "required",
        inspiratory_effort_comment: {
            required: {
                depends : function (){

                if($("#inspiratory_effort").val() == 'true'){
                        return true
                }else{
                    return false
                }
            }},
        },
        movement: "required",
        movement_comment: {
            required: {
                depends : function (){

                if($("#movement").val() == 'true'){
                        return true
                }else{
                    return false
                }
            }},
        },
        anatomical_marker: "required",
        anatomical_marker_comment: {
            required: {
                depends : function (){

                if($("#anatomical_marker").val() == 'true'){
                        return true
                }else{
                    return false
                }
            }},
        },
        others_quality: "required",
        others_quality_comment: {
            required: {
                depends : function (){

                if($("#others_quality").val() == 'true'){
                        return true
                }else{
                    return false
                }
            }},
        },
        thoracic_cage: "required",
        thoracic_cage_comment: {
            required: {
                depends : function (){

                if($("#thoracic_cage").val() == 'true'){
                        return true
                }else{
                    return false
                }
            }},
        },
        heart_size_shape: "required",
        heart_size_shape_comment: {
            required: {
                depends : function (){

                if($("#heart_size_shape").val() == 'true'){
                        return true
                }else{
                    return false
                }
            }},
        },
        lung_field: "required",
        lung_field_comment: {
            required: {
                depends : function (){

                if($("#lung_field").val() == 'true'){
                        return true
                }else{
                    return false
                }
            }},
        },
        mediastinum_hilar_region: "required",
        mediastinum_hilar_region_comment: {
            required: {
                depends : function (){

                if($("#mediastinum_hilar_region").val() == 'true'){
                        return true
                }else{
                    return false
                }
            }},
        },
        pleura: "required",
        pleura_comment: {
            required: {
                depends : function (){

                if($("#pleura").val() == 'true'){
                        return true
                }else{
                    return false
                }
            }},
        },
        focal_lesion: "required",
        focal_lesion_comment: {
            required: {
                depends : function (){

                if($("#focal_lesion").val() == 'true'){
                        return true
                }else{
                    return false
                }
            }},
        },
        other_findings: "required",
        other_findings_comment: {
            required: {
                depends : function (){

                if($("#other_findings").val() == 'true'){
                        return true
                }else{
                    return false
                }
            }},
        },
        impression: {
            required: {
                depends : function (){

                if(
                    $("#thoracic_cage").val() == 'true' || $("#heart_size_shape").val() == 'true' || $("#lung_field").val() == 'true' ||
                    $("#mediastinum_hilar_region").val() == 'true' || $("#pleura").val() == 'true' || $("#focal_lesion").val() == 'true' ||
                    $("#other_findings").val() == 'true'){
                        return true
                }else{
                    $("#impression").val('NORMAL');
                    return false
                }
            }},
        },
        decision: "required",
    },
    errorPlacement:
        function( error, element ){
            var id = element.attr("id");

            if(id == 'id_quality'){
                error.appendTo('#error_id_quality');
            }
            if(id == 'id_quality_comment'){
                error.appendTo('#error_id_quality_comment');
            }
            if(id == 'processing'){
                error.appendTo('#error_processing');
            }
            if(id == 'processing_comment'){
                error.appendTo('#error_processing_comment');
            }
            if(id == 'positioning'){
                error.appendTo('#error_positioning');
            }
            if(id == 'positioning_comment'){
                error.appendTo('#error_positioning_comment');
            }
            if(id == 'exposure'){
                error.appendTo('#error_exposure');
            }
            if(id == 'exposure_comment'){
                error.appendTo('#error_exposure_comment');
            }
            if(id == 'artifacts'){
                error.appendTo('#error_artifacts');
            }
            if(id == 'artifacts_comment'){
                error.appendTo('#error_artifacts_comment');
            }
            if(id == 'inspiratory_effort'){
                error.appendTo('#error_inspiratory_effort');
            }
            if(id == 'inspiratory_effort_comment'){
                error.appendTo('#error_inspiratory_effort_comment');
            }
            if(id == 'movement'){
                error.appendTo('#error_movement');
            }
            if(id == 'movement_comment'){
                error.appendTo('#error_movement_comment');
            }
            if(id == 'anatomical_marker'){
                error.appendTo('#error_anatomical_marker');
            }
            if(id == 'anatomical_marker_comment'){
                error.appendTo('#error_anatomical_marker_comment');
            }
            if(id == 'others_quality'){
                error.appendTo('#error_others_quality');
            }
            if(id == 'others_quality_comment'){
                error.appendTo('#error_others_quality_comment');
            }
            if(id == 'thoracic_cage'){
                error.appendTo('#error_thoracic_cage');
            }
            if(id == 'thoracic_cage_comment'){
                error.appendTo('#error_thoracic_cage_comment');
            }
            if(id == 'heart_size_shape'){
                error.appendTo('#error_heart_size_shape');
            }
            if(id == 'heart_size_shape_comment'){
                error.appendTo('#error_heart_size_shape_comment');
            }
            if(id == 'lung_field'){
                error.appendTo('#error_lung_field');
            }
            if(id == 'lung_field_comment'){
                error.appendTo('#error_lung_field_comment');
            }
            if(id == 'mediastinum_hilar_region'){
                error.appendTo('#error_mediastinum_hilar_region');
            }
            if(id == 'mediastinum_hilar_region_comment'){
                error.appendTo('#error_mediastinum_hilar_region_comment');
            }
            if(id == 'pleura'){
                error.appendTo('#error_pleura');
            }
            if(id == 'pleura_comment'){
                error.appendTo('#error_pleura_comment');
            }
            if(id == 'focal_lesion'){
                error.appendTo('#error_focal_lesion');
            }
            if(id == 'focal_lesion_comment'){
                error.appendTo('#error_focal_lesion_comment');
            }
            if(id == 'other_findings'){
                error.appendTo('#error_other_findings');
            }
            if(id == 'other_findings_comment'){
                error.appendTo('#error_other_findings_comment');
            }
            if(id == 'impression'){
                error.appendTo('#error_impression');
            }
            if(id == 'decision'){
                error.appendTo('#error_decision');
            }
        },


});

function getRadiologistReview(item, index){
    if(item === 'decision'){
        if ($('#'+item).val() == 'ABNORMAL'){
            $("#"+item+"_true").addClass('btn-danger');
            $("#"+item+"_false").removeClass('btn-success');
            $("#"+item+"_retake").removeClass('btn-warning');
        }else if ($('#'+item).val()== 'NORMAL'){
            $("#"+item+"_true").removeClass('btn-danger');
            $("#"+item+"_false").addClass('btn-success');
            $("#"+item+"_retake").removeClass('btn-warning');
        }else if ($('#'+item).val() == 'RETAKE'){
            $("#"+item+"_retake").addClass('btn-warning');
            $("#"+item+"_true").removeClass('btn-danger');
            $("#"+item+"_false").removeClass('btn-success');
        }
    }else{
        if ($('#'+item).val() == true){
            $("#"+item+"_true").addClass('btn-danger');
            $("#"+item+"_false").removeClass('btn-success');
        }else if($('#'+item).val() == false){
            $("#"+item+"_true").removeClass('btn-danger');
            $("#"+item+"_false").addClass('btn-success');
        }
    }
}
