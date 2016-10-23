ag.ns("ag.common");

(function(){

var cache = function() { };

cache.prototype.set = function(name, value)
{
    this.content[name] = value;
};

cache.prototype.has = function(name)
{
    return this.content[name] !== undefined;
};

cache.prototype.get = function(name)
{
    return this.content[name];
};

cache.prototype.content = {};

ag.common.Cache = cache;
ag.srv("cache", new cache());

})();
