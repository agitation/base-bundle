ag.ns("ag.common");

ag.common.Collection = function(list, options)
{
    var
        self = this,
        defaultOptions = { idCol : "id" },
        elements = {},
        opts = $.extend(true, defaultOptions, options || {}),

        updateLength = function()
        {
            self.length = Object.keys(elements).length;
        };

    self.length = 0;

    self.getList = function()
    {
        var elemList = [];

        Object.keys(elements).forEach(function(key){
            elemList.push(elements[key]);
        });

        return elemList;
    };

    self.get = function(id)
    {
        return elements[id];
    };

    self.add = function(element)
    {
        elements[element[opts.idCol]] = element;
        updateLength();
    };

    self.update = function(element)
    {
        elements[element[opts.idCol]] = element;
        updateLength();
    };

    // accepts either the ID or the element itself
    self.remove = function(element)
    {
        if (element[opts.idCol])
            delete(elements[element[opts.idCol]]);
        else
            delete(elements[element]);

        updateLength();
    };

    self.truncate = function()
    {
        elements = {};
        updateLength();
    };

    self.forEach = function(callback)
    {
        Object.keys(elements).forEach(function(key){
            callback(elements[key], key);
        });
    };

    self.sort = function(field, callback)
    {
        field = field || "name";

        return self.getList().sort(callback || function(elem1, elem2){
            return ag.ui.tool.fmt.out(elem1[field]).localeCompare(ag.ui.tool.fmt.out(elem2[field]));
        });
    };

    list && list.forEach(function(element){
        self.add(element);
    });
};
