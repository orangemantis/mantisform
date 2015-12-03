;(function(){
	String.prototype.capitalize = function(){
		var cap = this.charAt(0).toUpperCase();
		return cap + this.substr(1);
	};
})();