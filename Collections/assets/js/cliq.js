// cliq.js
sessionStorage.clear();
var sitepath = "http://"+document.location.hostname+"/", jspath = sitepath+"admin/modules/addons/Cliq/assets/js/";  

basket
// .remove() // "","" comma separated list
.require(

    // PHP.JS
    { url: jspath+'phpjs/var/unset.js' },
    { url: jspath+'phpjs/var/print_r.js' },
    { url: jspath+'phpjs/array/array_merge.js' },
    { url: jspath+'phpjs/array/array_key_exists.js' },
    { url: jspath+'phpjs/array/count.js' },
    { url: jspath+'phpjs/array/each.js' },
    { url: jspath+'phpjs/array/array_search.js' },
    { url: jspath+'phpjs/array/array_values.js' },
    { url: jspath+'phpjs/array/array_intersect_key.js' },
    { url: jspath+'phpjs/array/array_flip.js' },
    { url: jspath+'phpjs/array/array_replace.js' },
    { url: jspath+'phpjs/array/array_replace_recursive.js' },       
    
    { url: jspath+'phpjs/strings/explode.js' },
    { url: jspath+'phpjs/strings/implode.js' },
    { url: jspath+'phpjs/strings/str_replace.js' },
    { url: jspath+'phpjs/strings/trim.js' },
    { url: jspath+'phpjs/strings/stripos.js' },
    { url: jspath+'phpjs/strings/substr.js' },
    { url: jspath+'phpjs/strings/strstr.js' },
    { url: jspath+'phpjs/strings/strip_tags.js' }, 
    { url: jspath+'phpjs/strings/ucwords.js' },  
    
    { url: jspath+'phpjs/misc/uniqid.js' },
    { url: jspath+'phpjs/var/isset.js' },
    { url: jspath+'phpjs/url/rawurldecode.js' },
    { url: jspath+'phpjs/url/urlencode.js' },
    { url: jspath+'phpjs/json/json_encode.js' },
    { url: jspath+'phpjs/json/json_decode.js' },

    { url: jspath+'phpjs/language/require.js' },
    { url: jspath+'phpjs/language/foreach.js' },
    
    { url: jspath+'phpjs/url/base64_encode.js' },
    { url: jspath+'phpjs/url/base64_decode.js' }

).then(function(msg) {

}, function (error) {
    // There was an error fetching the script
    console.log(error);
});

/***************  Utility functions that have to be available at start  *****************************************************/

    /***
    * List functions here for descriptive purposes - 
    **/
    var Cliq = (function($) {
        
        // initialise
        // var shared values
        var cliqCfg = {
            useCaching: true,
            langcd: "en"
        }; 

        // Cliq.findOne('collection:help',{'reference':'$this.collection.name'})
        function getValue(tabletype, params) {
            var tm = explode(":", tabletype);
            var table = tm[0];
            var type = "";
            tm[1] ? type = tm[1] : type = "";
            return table+':'+type;
        }  

        /*
        function checkUnique(wid, fld, e) {
            
            var db = getRow(wid);
            var thisrecid = $("#"+wid+"_form input[name='recid']").val();
            if(thisrecid == 0) {
                var val = $("#"+wid+"_form input[name='"+fld+"']").val();
                var url = '/request/' + jlcd + '/isunique/' + db.clq_table + '/' + db.clq_tabletype + '/';
                var postdata = 'fld=' + fld + '&val=' + val;
                $.ajax({
                    url: url, data: postdata,
                    success: function(msg) {
                        // Test Ok or Not
                        var match = /Exists/.test(msg);
                        if (match == true) { 
                            useNoty({type: 'error', text:lstr[24]});
                            $("#"+wid+"_form input[name='"+fld+"']").val('').focus();
                            $.noty.closeAll();
                        } 
                    }, failure: function() {
                        useNoty({type: 'error', text:lstr[22]});
                    }
                });         
            }
            return false;       
        }

        function getNextRef(wid, fld, e) {
                            
            var db = getRow(wid); 
            var thisrecid = $("#"+wid+"_form input[name='recid']").val();
            console.log(thisrecid);
            if(thisrecid == 0) {
                var val = $("#"+wid+"_form input[name='"+fld+"']").val();
                var url = '/request/' + jlcd + '/getnextref/' + db.clq_table + '/' + db.clq_tabletype + '/';
                var postdata = 'fld=' + fld + '&defval=' + val;

                $.ajax({
                    url: url, data: postdata,
                    success: function(msg) {
                        // useNoty({text:msg});
                        $("#"+wid+"_form input[name='"+fld+"']").val(msg);
                        return false;
                    }, failure: function() {
                        useNoty({type: 'error', text:lstr[22]});
                    }
                });             
            }; return false;        
        }    
        */

        // explicitly return public methods when this object is instantiated
        return {
            findOne: getValue
        };

    })(jQuery); 

	function syntaxHighlight(json) {
	    if (typeof json != 'string') {
	         json = JSON.stringify(json, undefined, 2);
	    }
	    json = json.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
	    return json.replace(/("(\\u[a-zA-Z0-9]{4}|\\[^u]|[^\\"])*"(\s*:)?|\b(true|false|null)\b|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?)/g, function (match) {
	        var cls = 'number';
	        if (/^"/.test(match)) {
	            if (/:$/.test(match)) {
	                cls = 'key';
	            } else {
	                cls = 'string';
	            }
	        } else if (/true|false/.test(match)) {
	            cls = 'boolean';
	        } else if (/null/.test(match)) {
	            cls = 'null';
	        }
	        return '<span class="' + cls + '">' + match + '</span>';
	    });
	}

