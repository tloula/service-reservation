function loadServices(service){
    jQuery.getJSON("../apps/service-registration/admin.php?service="+service, function (json) {
        const data = json;

        var list = "<table class='table'>";
        list += "<thead style='font-weight: bold;'><tr><td>Date & Time</td><td>#</td></tr></thead><tbody>";
        jQuery.each(data.services, function (id, val) {
            list += "<tr>"
            list += "<td><a class='details' style='cursor: pointer;' id='" + val.id + "'>" + val.prettydt + "</a></td>";
            list += "<td>" + val.reserved + "</td>";
            list += "</tr>";
        });
        list += "</tbody></table>";
        jQuery("#services").empty().append(list);

        list = "<table class='table'>";
        list += "<thead style='font-weight: bold;'><tr><td>First</td><td>Last</td><td>Email</td><td>#</td><td>Timestamp (CT)</td></tr></thead><tbody>";
        jQuery.each(data.reservations, function (id, val) {
            list += "<tr>"
            list += "<td>" + val.first + "</td>";
            list += "<td>" + val.last + "</td>";
            list += "<td>" + val.email + "</td>";
            list += "<td>" + val.seats + "</td>";
            list += "<td>" + val.timestamp + "</td>";
            list += "</tr>";
        });
        list += "</tbody></table>";
        jQuery("#details").empty().append(list);
    });
}

jQuery(document).ready(function () {
    loadServices(0);
});

jQuery(document).on('click','.details', function() {
    loadServices(this.id);
});