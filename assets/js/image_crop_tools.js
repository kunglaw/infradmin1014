
/**
 * Function to display image according to given ratio.
 * @param data cropped/uploaded image data.
 * @param widthRatio ratio of width. 0 for free-ratio.
 * @param heightRatio ratio of height. 0 for free-ratio.
 */
function displayImageToRatio(data, widthRatio, heightRatio) {
	
	var parsedData = jQuery.parseJSON(data);

    var time = Math.round(new Date().getTime() / 1000);
    var imageHTML = '<img src="'+ parsedData.picture_link +'?time='+ time +'" style="max-width: 100%; height: auto;" id="cropbox" />'
	$("#result_image").html(imageHTML);


	// get input hidden value from ajax response.
	$("#picture_file_name").val(parsedData.file_name);
	$("#image_type").val(parsedData.image_type);
	$("#w_original").val(parsedData.w_original);
	$("#h_original").val(parsedData.h_original);

    // calculate displayed width and original width to get ratio.
    var displayToOriginalRatio = $("#cropbox").width() / parseInt(parsedData.w_original);

    var displayedWidth = $("#cropbox").width();
    var displayedHeight = displayToOriginalRatio * parsedData.h_original;

    var leftSide = displayedWidth * heightRatio; // w * h selection
    var rightSide = widthRatio * displayedHeight; // w selection * h

	var x2 = 0;
	var y2 = 0;

    // if displayed image has longer height than selected
    if (leftSide < rightSide) {
        x2 = displayedWidth;
        y2 = heightRatio * x2 / widthRatio;
    }
    // if displayed image has longer width than selected
    else if (leftSide > rightSide) {
        y2 = displayedHeight;
        x2 = widthRatio * y2 / heightRatio;
    }
    else {
        x2 = displayedWidth;
        y2 = displayedHeight;
    }
	
	var cropbox;
	
	if (widthRatio == 0 && heightRatio == 0) {

		// initialize crop utility for uploaded image with no ratio defined.
		cropbox = $("#cropbox").Jcrop({
			onSelect: updateCoordsNotFixed,
			setSelect: [0, 0, x2, y2]
		});

	} else {

		// initialize crop utility for uploaded image.
		cropbox = $("#cropbox").Jcrop({
			aspectRatio: widthRatio / heightRatio,
			onSelect: updateCoordsFixed,
			setSelect: [0, 0, x2, y2]
		});
	}

	// hide "choose" file for uploading button.
	$("#upload_section").hide();
}


/**
 * Update coordinate with ratio into hidden field.
 * @param c object coordinates.
 */
function updateCoordsFixed(c) {
	$("#x").val(c.x);
	$("#y").val(c.y);
	$("#w").val(c.w);
	$("#h").val(c.h);
	$("#w_displayed").val($("#cropbox").width());
	$("#h_displayed").val($("#cropbox").height());
}

/**
 * Update coordinate with no ratio at all,
 * setting target width and height into selection.
 * @param c object coordinates.
 */
function updateCoordsNotFixed(c) {
	$("#x").val(c.x);
	$("#y").val(c.y);
	$("#w").val(c.w);
	$("#h").val(c.h);
	$("#final_width").val(c.w);
	$("#final_height").val(c.h);
	$("#w_displayed").val($("#cropbox").width());
	$("#h_displayed").val($("#cropbox").height());
}