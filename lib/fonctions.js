var Try =
{
	these: function()
	{
		var returnValue;
		for ( var i = 0, length = arguments.length; i < length; i++ )
		{
			var lambda = arguments[i];
			try
			{
				returnValue = lambda();
				break;
			}
			catch( e )
			{ }
		}
		return returnValue;
	}
}
function toURI(elem)
{
	return encodeURIComponent( elem.val() );
}
function a(f)
{
	jQuery( function()
	{
		f(jQuery);
	} );
}