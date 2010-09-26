<?php

return new ExampleWebSocket;

class ExampleWebSocket extends AppInstance {
	/**
	 * @method onReady
	 * @description Called when the worker is ready to go.
	 * @return void
	 */
	public function onReady() {
		if ($this->WS = Daemon::$appResolver->getInstanceByAppName('WebSocketServer')) {
			$this->WS->addRoute('exampleApp',function ($client)
			{
			 return new ExampleWebSocketSession($client);
			});
		}
	}
}

class ExampleWebSocketSession extends WebSocketRoute { 

	/**
	 * @method onFrame
	 * @description Called when new frame received.
	 * @param string Frame's contents.
	 * @param integer Frame's type.
	 * @return void
	 */
	public function onFrame($data, $type) {
		if ($data === 'ping') {
			$this->client->sendFrame('pong', WebSocketSERVER::STRING,
				function($client) {
					Daemon::log('ExampleWebSocket: \'pong\' received by client.');
				}
			);
  		}
	}
}
