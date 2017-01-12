ag.ns("ag.common");

(function(){
    var

        pad = function(num)
        {
            return ag.ui.tool.fmt.numpad(num, 2);
        };

    ag.common.Time = function(hourOrObjectOrString, minute)
    {
        if (typeof(hourOrObjectOrString) === "string")
        {
            this.fromString(hourOrObjectOrString);
        }
        else if (typeof(hourOrObjectOrString) === "object" && hourOrObjectOrString !== null)
        {
            this.hour = hourOrObjectOrString.hour;
            this.minute = hourOrObjectOrString.minute;
        }
        else
        {
            var now = minute === undefined ? null : new Date();

            this.hour = hourOrObjectOrString || now.getUTCHours();
            this.minute = minute === undefined ? now.getUTCMinutes() : minute;
        }
    };

    ag.common.Time.prototype.toNumber = function()
    {
        return this.hour * 100 + this.minute;
    };

    ag.common.Time.prototype.toString = function()
    {
        return pad(this.hour) + ":" + pad(this.minute);
    };

    // expects a string such as "15:24"
    ag.common.Time.prototype.fromString = function(value)
    {
        var parts = value.split(":").map(function(part){ return parseInt(part); });

        if (parts[0] >= 0 && parts[0] <= 23 && parts[1] >= 0 && parts[1] <= 59)
        {
            this.hour = parts[0];
            this.minute = parts[1];
        }
    };

    ag.common.Time.prototype.format = function(fmt)
    {
        var date = new Date(new Date(Date.UTC(1970, 0, 1, this.hour, this.minute, 0)));
        return ag.ui.tool.date.format(date, fmt);
    };

    ag.common.Time.prototype.compare = function(time)
    {
        var
            t1 = this.toNumber(),
            t2 = time.toNumber(),
            ret = 0;

        if      (t1 > t2)   ret = 1;
        else if (t1 < t2)   ret = -1;

        return ret;
    };
})();
