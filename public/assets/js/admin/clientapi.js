/*************************************************************[clientserviceapi]*
 * Copyright (C) 2019-2021 IoT Laboratory Jasa Marga (https://jmiot.org)
 *
 * Licensed under the IoT Laboratory Jasa Marga License 1.0.0;
 * You may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      https://jmiot.org/
 *
 * Use, modify and distributing all or some part of this source is prohibited
 * without IoT Laboratory Jasa Marga permission.
 *______________________________________________________________________________
 *
 * Filename    : clientserviceapi.js
 * Description : Client Service API
 *
 */
(function(){ /* isolated code */
	/* Public API */
	var api={};
	window.IOTClientService=api; /* PUBLIC API */
	
	/* Private Vars */
	var ws_url = "ws://localhost:4949/";
	var ws=null;
	var ws_isconnected = false;
	var ws_opened = false;
	var cs_status = {};
	var cmd_callbacks = [];
	
	/* Init Public Callbacks */
	api.onconnect=null;
	api.ondisconnect=null;
	api.onlog=null;
	api.onmessage=null;
	
	/* Private method */
	function _log(v){
		if (api.onlog){
			api.onlog(v);
		}
	}
	async function send_command(c,force){
		if (force||('active' in cs_status)) {
			if (force||(cs_status.active)){
				let retval = new Promise((ret) => {
					var err_to = setTimeout(() => ret(false), 2000);
					cmd_callbacks.push([
						c, function(v){
							clearTimeout(err_to);
							if (v.code==0){
								ret(v);
							}
							ret(v);
						}
					]);
				});
				_log("  >> "+c);
				ws.send(c);
				return await retval;
			}
		}
		return false;
	}
	/* Start WS */
	function start_ws(){
		if (!ws_opened) return;
		ws = new WebSocket(ws_url);
		ws.onopen = function() {
			_log("[*] connected");
			if (api.onconnect) api.onconnect();
			ws_isconnected=true;
		};

		ws.onmessage = function (evt) {
			_log("<< " + evt.data);
			var m = JSON.parse(evt.data);
			if ('response' in m){
				for (var i=0;i<cmd_callbacks.length;i++){
					if (m.response==cmd_callbacks[i][0]){
						cmd_callbacks[i][1](m);
						cmd_callbacks.splice(i, 1);
						break;
					}
				}
			}
			else if ('uid' in m){
				cs_status = m;
			}
			if (api.onmessage) api.onmessage(m);
		};

		ws.onclose = function() {
			if (ws_isconnected){
				_log("[*] disconnected");
				if (api.ondisconnect) api.ondisconnect();
				ws_isconnected=false;
			}
			if (ws_opened){
				setTimeout(start_ws,1000);
			}
		};
	}
	
	/* Public Functions */
	api.send=send_command;
	api.is_active=function(){
		if ('active' in cs_status){
			return cs_status.active;
		}
		return false;
	};
	api.getuid=function(){
		return (api.is_active())?cs_status.uid:"";
	};
	api.getport=function(){
		return (api.is_active())?cs_status.comports:[];
	};
	api.getcom=function(){
		return (api.is_active())?cs_status.com:"";
	};
	api.getstatus=function(){
		return cs_status;
	};
	api.auth=(async function(sector, keytype, key){
		var res = await send_command("auth "+sector+" "+keytype+" "+key);
		if ((res)&&(res.code==0))
			return true;
		return false;
	});
	api.read=(async function(block){
		var res = await send_command("read "+block);
		if ((res)&&(res.code==0))
			return res.value;
		return false;
	});
	api.write=(async function(block, data){
		var res = await send_command("write "+block+" "+data);
		if ((res)&&(res.code==0))
			return true;
		return false;
	});
	api.read_sector=(async function(sector, keytype, key){
		var data=[];
		if (await api.auth(sector,keytype,key)){
			for (var i=0;i<3;i++){
				var res = await api.read(sector*4+i);
				if (res){
					data.push(res);
				}
				else{
					api.finish();
					return false;
				}
			}
			api.finish();
			return data;
		}
		return false;
	});
	api.write_sector=(async function(sector, keytype, key, block0, block1, block2){
		var data=[];
		if (await api.auth(sector,keytype,key)){
			if (!(await api.write(sector*4,block0))) return false;
			if (!(await api.write(sector*4+1,block1))) return false;
			if (!(await api.write(sector*4+2,block2))) return false;
			api.finish();
			return true;
		}
		return false;
	});
	api.finish=(async function(){
		var res = await send_command("finish");
		if ((res)&&(res.code==0))
			return true;
		return false;
	});
	api.beep=(async function(){
		var res = await send_command("beep");
		if ((res)&&(res.code==0))
			return true;
		return false;
	});
	api.setcom=(async function(port){
		var res = await send_command("com "+port,true);
		if ((res)&&(res.code==0))
			return true;
		return false;
	});
	api.open=function(){
		if (ws){
			ws.close();
		}
		ws_opened=true;
		start_ws();
	};
	
	api.close=function(){
		ws_opened=false;
		ws.close();
	};
})();
