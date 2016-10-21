ag.ns("ag.common");

(function(){
var
    plugins = function()
    {
        this.plugins = {};
    };

    plugins.prototype.register = function(pluggableName, pluginName, plugin)
    {
        if (!this.plugins[pluggableName])
            this.plugins[pluggableName] = {};

        this.plugins[pluggableName][pluginName] = plugin;
    };

    plugins.prototype.get = function(pluggableName)
    {
        return this.plugins[pluggableName] || {};
    };

    ag.common.Plugins = plugins;
    ag.srv("plugins", new plugins());

})();
