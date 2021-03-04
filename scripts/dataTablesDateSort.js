// custom function defined by aman.
jQuery.fn.dataTable.ext.type.order['time-elapsed-dhms-pre'] = function (data) {
    const mult = { "day": 86400, "hr": 3600, "min": 60, "s": 1 }
    let total = 0;
    splitted = data.split(" ");

    splitted.forEach((value)=>{
        if (value.includes("day")) {
            total += value.split("day")[0] * 86400;
        } else if (value.includes("hr")) {
            total += value.split("hr")[0] * 3600;
        } else if (value.includes("min")) {
            total += value.split("min")[0] * 60;
        } else {
            total += value.split("s")[0] * 1;
        }
    });

    return total;
}