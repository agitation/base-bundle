ag.ns("ag.common");

(function(){

var Cache = function()
{
    this.content = {};
};

Cache.prototype.set = function(name, value)
{
    this.content[name] = value;
};

Cache.prototype.has = function(name)
{
    return this.content[name] !== undefined;
};

Cache.prototype.get = function(name)
{
    return this.content[name];
};

ag.s.cache = new Cache();

})();
