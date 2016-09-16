ag.ns("ag.plg");

(function(){
var
    registry = function()
    {
        this.plugins = {};
    };

    registry.prototype.registerPlugin = function(pluggableName, pluginName, plugin)
    {
        if (!this.plugins[pluggableName])
            this.plugins[pluggableName] = {};

        this.plugins[pluggableName][pluginName] = plugin;
    };

    registry.prototype.getPlugins = function(pluggableName)
    {
        return this.plugins[pluggableName] || {};
    };

    ag.plg.registry = new registry();
})();
