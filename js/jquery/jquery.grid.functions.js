/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function buscarGrid(table) {
// When document is ready: this gets fired before body onload :)
    $("#kwd_search").keyup(function() {
        // When value of the input is not blank
        if ($(this).val() != "")
        {
            // Show only matching TR, hide rest of them
            $("#" + table + " tbody>tr").hide();
            $("#" + table + " td:contains-ci('" + $(this).val() + "')").parent("tr").show();
        }
        else
        {
            // When there is no input or clean again, show everything back
            $("#" + table + "  tbody>tr").show();
        }
    });
}


/////para comparar fechas en cadena solo dd/mm/yyyy

var date_from_string = function(str) {
    var res = str.split("/");
    return parseInt(res[2] + res[1] + res[0]);
};



// jQuery expression for case-insensitive filter
$.extend($.expr[":"],
        {
            "contains-ci": function(elem, i, match, array)
            {
                return (elem.textContent || elem.innerText || $(elem).text() || "").toLowerCase().indexOf((match[3] || "").toLowerCase()) >= 0;
            }
        });




//ordenamiento
(function(c) {
    c.fn.ordenarTabla = function(b) {
        return this.each(function() {
            var a = c(this);
            b = b || {};
            b = c.extend({}, c.fn.ordenarTabla.default_sort_fns, b);
            a.on("click.ordenarTabla", "th", function() {
                var d = c(this), f = 0, g = c.fn.ordenarTabla.dir;
                a.find("th").slice(0, d.index()).each(function() {
                    var a = c(this).attr("colspan") || 1;
                    f += parseInt(a, 10)
                });
                var e = d.data("sort-default") || g.ASC;
                d.data("sort-dir") && (e = d.data("sort-dir") === g.ASC ? g.DESC : g.ASC);
                var l = d.data("sort") || null;
                null !== l && (a.trigger("beforetablesort", {column: f, direction: e}), a.css("display"), setTimeout(function() {
                    var h = [], m = b[l], k = a.children("tbody").children("tr");
                    k.each(function(a, b) {
                        var d = c(b).children().eq(f), e = d.data("sort-value"), d = "undefined" !== typeof e ? e : d.text();
                        h.push([d, b])
                    });
                    h.sort(function(a, b) {
                        return m(a[0], b[0])
                    });
                    e != g.ASC && h.reverse();
                    k = c.map(h, function(a) {
                        return a[1]
                    });
                    a.children("tbody").append(k);
                    a.find("th").data("sort-dir", null).removeClass("sorting-desc sorting-asc");
                    d.data("sort-dir", e).addClass("sorting-" + e);
                    a.trigger("aftertablesort", {column: f, direction: e});
                    a.css("display")
                }, 10))
            })
        })
    };
    c.fn.ordenarTabla.dir = {ASC: "asc", DESC: "desc"};
    c.fn.ordenarTabla.default_sort_fns = {"int": function(b, a) {
            return parseInt(b, 10) - parseInt(a, 10)
        }, "float": function(b, a) {
            return parseFloat(b) - parseFloat(a)
        }, "date": function(b, a) {
            return date_from_string(a) - date_from_string(b)
        }, "string": function(b, a) {
            b = b.toLowerCase();
            a = a.toLowerCase();
            return b < a ? -1 : b > a ? 1 : 0
        }}
})(jQuery);