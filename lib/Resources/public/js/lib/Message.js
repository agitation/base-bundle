ag.ns("ag.common");


ag.common.Message = function(text, type, category)
{
    type = type || 'info';
    category = category || '';

    this.getType = function()
    {
        return type;
    };

    this.getText = function()
    {
        return text;
    };

    this.getCategory = function()
    {
        return category;
    };
};
