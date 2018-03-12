ag.ns("ag.common");

(function(){
    var
        pad = function(num, len)
        {
            return ag.u.numpad(num, len || 2);
        };

    ag.common.Date = function(yearOrObjectOrString, month, day)
    {
        if (typeof(yearOrObjectOrString) === "string")
        {
            this.fromString(yearOrObjectOrString);
        }
        else if (typeof(yearOrObjectOrString) === "object" && yearOrObjectOrString !== null)
        {
            this.day = yearOrObjectOrString.day;
            this.month = yearOrObjectOrString.month;
            this.year = yearOrObjectOrString.year;
        }
        else
        {
            var now = day ? null : new Date();

            this.day = day || now.getUTCDate();
            this.month = month || now.getUTCMonth() + 1;
            this.year = yearOrObjectOrString || now.getUTCFullYear();
        }
    };

    ag.common.Date.prototype.toNumber = function()
    {
        return this.year * 10000 + this.month * 100 + this.day;
    };

    ag.common.Date.prototype.toString = function()
    {
        return pad(this.year, 4) + "-" + pad(this.month) + "-" + pad(this.day);
    };

    // expects a string such as "2020-12-30"
    ag.common.Date.prototype.fromString = function(value)
    {
        var parts = value.split("-").map(function(part){ return parseInt(part); });

        if (parts[0] >= 1900 && parts[0] <= 2100 && parts[1] >= 1 && parts[1] <= 12 && parts[2] >= 1 && parts[2] <= 31)
        {
            this.year = parts[0];
            this.month = parts[1];
            this.day = parts[2];
        }
    };

    ag.common.Date.prototype.format = function(fmt)
    {
        var date = new Date(new Date(Date.UTC(this.year, this.month - 1, this.day, 0, 0, 0)));
        return ag.u.date.format(date, fmt);
    };

    ag.common.Date.prototype.compare = function(day)
    {
        var
            d1 = this.toNumber(),
            d2 = day ? day.toNumber() : 0,
            ret = 0;

        if      (d1 > d2)   ret = 1;
        else if (d1 < d2)   ret = -1;

        return ret;
    };

    ag.common.Date.prototype.getDate = function()
    {
        return new Date(Date.UTC(this.year, this.month - 1, this.day));
    };

    ag.common.Date.prototype.clone = function()
    {
        return new ag.common.Date(this.year, this.month, this.day);
    };

    ag.common.Date.prototype.diff = function(offset)
    {
        var date = this.getDate();

        date.setUTCDate(date.getUTCDate() + offset);

        return new ag.common.Date(date.getUTCFullYear(), date.getUTCMonth() + 1, date.getUTCDate());
    };
})();
