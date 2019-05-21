$(document).ready(function () {

    let imageSelected = false;
    let widget;

    $("form").on("submit", () => {
        
        if (imageSelected) {

            $("input[name=\"width\"]").val(widget.pos.w);
            $("input[name=\"height\"]").val(widget.pos.h);
            $("input[name=\"x\"]").val(widget.pos.x);
            $("input[name=\"y\"]").val(widget.pos.y);
            
        } else {
            const file = document.querySelector("input[type=\"file\"]").files[0]; // Too lazy to figure out how to do this in jQuery.
            const validTypes = ["image/jpeg", "image/png"];
            if (validTypes.includes(file.type)) {
                const FR = new FileReader();
                FR.onload = () => {
                    const attached = Jcrop.attach("avatar");
                    const avatarEl = $("#avatar");
                    avatarEl.attr("id", "");
                    avatarEl.attr("src", FR.result);
                    const rect = Jcrop.Rect.fromPoints([0, 0], [Math.min(200, avatarEl.width()), Math.min(200, avatarEl.height())])
                    widget = attached.newWidget(rect, { aspectRatio: rect.aspect });
                    attached.addWidget(widget);
                    imageSelected = true;
                    $("#fileInput").hide();
                    $(".title").text("Crop Your Profile Picture");
                    $("input[type=\"submit\"]").val("Upload");
                };
                try {
                    FR.readAsDataURL(file);
                } catch (_) {
                    $("#invalidFile").show();
                }
            } else {
                // Error.
                $("#invalidFile").show();
            }
            return false;
        }


    });
});