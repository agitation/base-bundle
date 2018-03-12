ag.ns("ag.common");

(function(){

var
    defaultOptions = { idCol : "id" },

    collection = function(list, options)
    {
        var self = this;

        this.opts = $.extend(true, defaultOptions, options || {});
        this.elements = {};

        if (list)
            list.forEach(function(element){
                self.add(element);
            });
    },

    updateLength = function()
    {
        this.length = Object.keys(this.elements).length;
    };

collection.prototype.length = 0;

collection.prototype.getList = function()
{
    var self = this, elemList = [];

    Object.keys(self.elements).forEach(function(key){
        elemList.push(self.elements[key]);
    });

    return elemList;
};

collection.prototype.get = function(id)
{
    return this.elements[id];
};

collection.prototype.add = function(element)
{
    this.elements[element[this.opts.idCol]] = element;
    updateLength.call(this);
};

collection.prototype.update = function(element)
{
    this.elements[element[this.opts.idCol]] = element;
    updateLength.call(this);
};

// accepts either the ID or the element itself
collection.prototype.remove = function(element)
{
    if (element[this.opts.idCol])
        delete(this.elements[element[this.opts.idCol]]);
    else
        delete(this.elements[element]);

    updateLength.call(this);
};

collection.prototype.truncate = function()
{
    this.elements = {};
    updateLength.call(this);
};

collection.prototype.forEach = function(callback)
{
    var self = this;

    Object.keys(self.elements).forEach(function(key){
        callback(self.elements[key], key);
    });
};

collection.prototype.sort = function(field, callback)
{
    field = field || "name";

    return this.getList().sort(callback || function(elem1, elem2){
        return ag.u.out(elem1[field]).localeCompare(ag.u.out(elem2[field]));
    });
};

ag.common.Collection = collection;

})();
