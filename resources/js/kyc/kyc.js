(function (a) {
    var c = a(".document-type");
    0 < c.length && c.on("click", function () {
        var b = a(this).data("title"),
            c = a(".doc-upload-d2"),
            d = "undefined" != typeof a(this).data("change"),
            e = a(this).data("img");
        a(".doc-type-name").text(b), a("._image").attr("src", e), 0 < c.length && d ? c.removeClass("hide") : c.addClass("hide")
    });
})(jQuery);
