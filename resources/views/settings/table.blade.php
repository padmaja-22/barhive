<!DOCTYPE html>
<html>
<head>

    <!-- Bootstrap Core CSS -->
    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sb-admin-2.css') }}" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>

    <script src="https://unpkg.com/konva@2.4.2/konva.min.js"></script>
    <script src="/js/vue.min.js"></script>
    <script src="/js/vue-resource.min.js"></script>

    <meta charset="utf-8">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>BarHive</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            overflow: hidden;
            background-image: url("{{ asset('img/wood_floor.jpg') }}");
        }
        #button {
            position: absolute;
            left: 10px;
            top: 0px;
        }
        button {
            margin-top: 10px;
            display: block;
        }
    </style>
</head>
<body>
<div id="container"></div>

<div id="button" class="container-fluid">
    <a href="/dashboard"><button id="exit" class="btn btn-danger">Exit layout builder</button></a>
    <button id="save" class="btn btn-primary">
        Save layout
    </button>
    <br><button id="addSquare" class="btn btn-success">
        Add square table
    </button>
    <br><button id="addRound" class="btn btn-success">
        Add round table
    </button>
</div>


<script>

    var stage;
    var layer;
    var rectX;
    var rectY;
    var counter;
    var deleteLayer;

    window.onload = function() {

        drawDeleteArea = function() {
            this.deleteLayer = new Konva.Layer();
            let deleteRect = new Konva.Rect({
                x: 0,
                y: this.stage.getHeight() - 100,
                width: this.stage.getWidth(),
                height:100,
                fillLinearGradientStartPoint: { x: 0, y: 0 },
                fillLinearGradientEndPoint: { x: 0, y: 150 },
                fillLinearGradientColorStops: [0, '#bc976b', 1, 'red'],
                id: 'delete',
            });
            let text = new Konva.Text({
                text: 'DELETE',
                fill: '#ffffff',
                fontSize: 40,
                x: (this.stage.getWidth() / 2) - 150,
                y: this.stage.getHeight() - 50,
                id: 'delete',
            });
            let group = new Konva.Group();
            group.add(deleteRect);
            group.add(text);

            this.deleteLayer.add(group);
            this.stage.add(this.deleteLayer);
            this.deleteLayer.moveToBottom();
        }

        removeDeleteArea = function(group) {
            let pos = this.stage.getPointerPosition();
            let shape = this.deleteLayer.getIntersection(pos);
            if (shape) {
                if (shape.getAttr('id') == 'delete') {
                    group.destroy();
                    this.layer.draw();
                }
            }
            this.deleteLayer.destroyChildren();
            this.deleteLayer.draw();
        }

        renameTable = function(group) {
            console.log(group);
            let newName = prompt('New name');
            if (newName) {
                let text = group.find('.text')[0];
                text.setAttr('text', newName);
                this.layer.draw();
            }
        }

        Vue.http.get('/settings/table/layout').then(response => {
           layout = response.body;

           if (layout.length == 0) {
               var width = window.innerWidth;
               var height = window.innerHeight;

               this.stage = new Konva.Stage({
                   container: 'container',
                   width: width,
                   height: height,
               });
               this.counter = 1;

               this.layer = new Konva.Layer({
                   id: 'main',
               });
               this.rectX = this.stage.getWidth() / 2 - 50;
               this.rectY = this.stage.getHeight() / 2 - 25;

               this.stage.add(layer);
           } else {
               this.stage = Konva.Node.create(JSON.parse(layout[0].json), 'container');
               this.stage.setWidth(window.innerWidth);
               this.stage.setHeight(window.innerHeight);
               this.layer = this.stage.find('#main')[0];

               this.layer.getChildren().each(function (group) {
                   group.on('mouseover', function() {
                       document.body.style.cursor = 'pointer';
                   });
                   group.on('mouseout', function() {
                       document.body.style.cursor = 'default';
                   });
                   group.on('dragstart', function() {
                       drawDeleteArea();
                   });
                   group.on('dragend', function() {
                       removeDeleteArea(group);
                   });
                   group.on('dblclick', function() {
                       renameTable(group);
                   });
               });

               this.counter = this.layer.getChildren().length + 1;

               this.rectX = this.stage.getWidth() / 2 - 50;
               this.rectY = this.stage.getHeight() / 2 - 25;
           }
        }).bind(this);
    }

    document.getElementById('addSquare').addEventListener('click', function() {
        let box = new Konva.Rect({
            x: rectX,
            y: rectY,
            width: 100,
            height: 50,
            fill: '#ffffff',
            stroke: '#5a3e2d',
            strokeWidth: 2,
            name: 'table',
        });

        let text = new Konva.Text({
            text: counter.toString(),
            fill: '#5a3e2d',
            fontSize: 25,
            x: rectX + 40,
            y: rectY + 15,
            name: 'text',
        });

        let group = new Konva.Group({
            draggable: true,
        });

        // add cursor styling
        group.on('mouseover', function() {
            document.body.style.cursor = 'pointer';
        });
        group.on('mouseout', function() {
            document.body.style.cursor = 'default';
        });
        group.on('dragstart', function() {
            drawDeleteArea();
        });
        group.on('dragend', function() {
            removeDeleteArea(group);
        });
        group.on('dblclick', function() {
            renameTable(group);
        });

        group.add(box);
        group.add(text);
        layer.add(group);
        layer.draw();

        counter++;
    }, false);

    document.getElementById('addRound').addEventListener('click', function() {
        let circ = new Konva.Circle({
            x: rectX,
            y: rectY,
            radius: 35,
            fill: '#ffffff',
            stroke: '#5a3e2d',
            strokeWidth: 2,
            name: 'table',
        });

        let text = new Konva.Text({
            text: counter.toString(),
            fill: '#5a3e2d',
            fontSize: 25,
            x: rectX - 8,
            y: rectY - 8,
            name: 'text',
        });

        let group = new Konva.Group({
            draggable: true,
        });

        // add cursor styling
        group.on('mouseover', function() {
            document.body.style.cursor = 'pointer';
        });
        group.on('mouseout', function() {
            document.body.style.cursor = 'default';
        });
        group.on('dragstart', function() {
            drawDeleteArea();
        });
        group.on('dragend', function() {
            removeDeleteArea(group);
        });
        group.on('dblclick', function() {
            renameTable(group);
        });

        group.add(circ);
        group.add(text);
        layer.add(group);
        layer.draw();

        counter++;
    }, false);

    document.getElementById('save').addEventListener('click', function() {
        var layout = stage.toJSON();

        Vue.http.post('/settings/table/layout', {jsonLayout: layout}, {
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    }, false);
</script>

</body>
</html>