<div>

    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-sm-12 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                                </svg>
                            </a>
                        </li>
                        <li class="breadcrumb-item dana">نقشه</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section wire:ignore>
        <x-partials.alert.warning-alert />
    </section>
    <div class="row">
        <div class="row">
            <div class="col-md-4">
                <div class="email-right-aside bookmark-tabcontent">
                    <div class="card email-body radius-left">
                        <div class="ps-0">
                            <div class="tab-content">
                                <div id="pills-created" role="tabpanel">
                                    <div class="card mb-0">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <h5>دستگاه ها</h5>
                                            <div wire:ignore>
                                                <ul class="tg-list common-flex">
                                                    <li class="tg-list-item">
                                                        <input class="tgl tgl-skewed" id="cb3" type="checkbox"
                                                            wire:click="changeMode" @checked($onlineMode)>
                                                        <label class="tgl-btn" data-tg-off="آفلاین" data-tg-on="آنلاین"
                                                            for="cb3"></label>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="card-body p-0 device-sidebar overflow-y-auto">
                                            <div class="col-12 position-absolute" style="z-index: 7">
                                                <input class="form-control rounded-0" id="search" type="text"
                                                    placeholder="جستجو بر اساس نام یا شناسه..." aria-label="جسنجو"
                                                    wire:model.live.debounce.850ms="search">
                                                <x-input-error :messages="$errors->get('search')" class="mt-1" />
                                            </div>
                                            <div class="taskadd visible-scroll">
                                                <div class="table-responsive text-nowrap" x-data="{
                                                    scrollToMap() {
                                                        const mapEl = document.getElementById('map');
                                                        if (mapEl) {
                                                            mapEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
                                                        }
                                                    }
                                                }">
                                                    <table class="table mt-5" @if($onlineMode) wire:poll.4s.keep-alive @endif>
                                                        <tbody>
                                                            <tr>
                                                                <td @class([
                                                                    'w-100 d-none justify-content-start align-items-center',
                                                                    'd-flex' => $errors->has('selected'),
                                                                ])>
                                                                    <x-input-error :messages="$errors->get('selected')" class="mt-1" />
                                                                </td>
                                                                <td @class([
                                                                    'w-100 d-none justify-content-start align-items-center',
                                                                    'd-flex' => $errors->has('selected.*'),
                                                                ])>
                                                                    <x-input-error :messages="$errors->get('selected.*')" class="mt-1" />
                                                                </td>
                                                            </tr>
                                                            @forelse($devices as $key => $device)
                                                                <tr wire:key="{{ $device->id }}"
                                                                    @click="scrollToMap()">
                                                                    <td
                                                                        class="w-100 d-flex justify-content-between align-items-center">
                                                                        <div
                                                                            class="d-flex justify-content-start align-items-center me-3">
                                                                            <input type="checkbox"
                                                                                id="input-{{ $key }}"
                                                                                value="{{ $device->id }}"
                                                                                class="ui-checkbox me-2"
                                                                                @checked(in_array($device->id, $selected))
                                                                                wire:model.live="selected">
                                                                            <label for="input-{{ $key }}"
                                                                                class="cursor-pointer">
                                                                                <h6 class="task_title_0">
                                                                                    دستگاه
                                                                                    {{ str($device->name)->replace('دستگاه', '') }}
                                                                                </h6>
                                                                                <small
                                                                                    class="project_name_0 text-muted d-block">{{ $device->serial }}</small>
                                                                                <small
                                                                                    class="project_name_0 text-muted d-block">{{ $device->user?->name }}</small>
                                                                            </label>
                                                                        </div>
                                                                        @if ($device->lastLocation())
                                                                            <div
                                                                                class="d-flex justify-content-end align-items-center">
                                                                                <span>KM/H <strong
                                                                                        class="text-success">{{ json_decode($device?->lastLocation()->device_stats)?->speed }}</strong></span>
                                                                            </div>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                                <tr x-intersect.once="$wire.loadMore()"></tr>
                                                            @empty
                                                                <tr>
                                                                    <p class="text-muted text-center">دستگاهی یافت نشد.
                                                                    </p>
                                                                </tr>
                                                            @endforelse
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-xl-6" x-data="dateTimeRange($refs.dateRangeInp)">
                                <label class="form-label" for="datetime-range">انتخاب تاریخ: </label>
                                <div class=" d-flex align-items-center justify-content-start">
                                    <div class="input-group flatpicker-calender">
                                        <div class="input-group flatpicker-calender" wire:ignore>
                                            <input class="form-control" id="datetime-range" type="date"
                                                wire:model="dateTimeRange" x-ref="dateRangeInp">
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-start align-items-center ms-2"><a
                                            class="btn btn-primary f-w-500" type="button" wire:click="handleTrip"
                                            :class="disabled && 'disabled'">فیلتر</a>
                                    </div>
                                </div>
                                <x-input-error :messages="$errors->get('dateTimeRange')" class="mt-1" />
                            </div>

                            <div class="col-12 col-xl-6" wire:ignore x-data="trackplayer">
                                <label class="form-label">تنظیمات پخش:</label>
                                <div class="d-flex flex-row-reverse justify-content-between align-items-center">
                                    <div class="d-flex">
                                        <button class="btn btn-warning-gradien px-2" data-bs-toggle="tooltip"
                                            @click="removeTracker()" data-bs-placement="top" title="حذف پخش کننده">
                                            <img class="img-fluid"
                                                src="{{ asset('assets/libs/leaflet/track-player/icons/close-square-svgrepo-com.svg') }}"
                                                width="24" height="24" alt="">
                                        </button>

                                        <button class="btn btn-warning-gradien px-2 mx-1" data-bs-toggle="tooltip"
                                            @click="changeSpeed()" :disabled="!btnStatus" data-bs-placement="top"
                                            title="سرعت">
                                            <span class="text-dark f-w-900" x-show="displaySpeed"
                                                x-text="displaySpeed"></span>
                                            <img class="img-fluid" x-show="!displaySpeed"
                                                src="{{ asset('assets/libs/leaflet/track-player/icons/playback-speed-svgrepo-com.svg') }}"
                                                width="24" height="24" alt="سرعت">
                                        </button>

                                        <button class="btn btn-warning-gradien  px-2" @click="togglePlay()"
                                            :disabled="!btnStatus" :title="isPlaying ? 'توقف کردن' : 'پخش کردن'">
                                            <img class="img-fluid"
                                                :src="isPlaying ?
                                                    '{{ asset('assets/libs/leaflet/track-player/icons/pause-circle-svgrepo-com.svg') }}' :
                                                    '{{ asset('assets/libs/leaflet/track-player/icons/play-circle-svgrepo-com.svg') }}'"
                                                width="24" height="24" alt="">
                                        </button>
                                    </div>

                                    <div class="range-d-slider">
                                        <div x-ref="slider_thumb" class="range-d-slider_thumb"></div>
                                        <div class="range-d-slider_line">
                                            <div x-ref="slider_line" class="range-d-slider_line-fill"></div>
                                        </div>
                                        <input x-ref="slider_input" class="range-d-slider_input" type="range"
                                            :disabled="!btnStatus" @input="handleSliderInput($event)" min="0"
                                            max="100" :value="currentProgress">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="card-body z-1 position-relative" x-data="mapComponent" wire:ignore>
                    <div @remove-all.window="removeWayPoints()"></div>
                    <div @appear-waypoints.window="showWaypoints(trips)"></div>
                    <div class="map-js-height" x-ref="map" id="map"></div>

                    <div id="spinner-loader" wire:loading wire:target="updatedSelected, updateDeviceLocation, handleTrip, loadMore, changeMode">
                        <div class="bg-loader">
                            <div class="loader"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@assets
    <!-- // Leaflet JS assets  -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/leaflet/leaflet.css') }}">
    <script src="{{ asset('assets/libs/leaflet/leaflet.js') }}"></script>
    <script src="{{ asset('assets/libs/leaflet/leaflet-map-layers.js') }}"></script>

    <!-- // Leaflet Geoman for Geofence assets  -->
    <link rel="stylesheet" href="https://unpkg.com/@geoman-io/leaflet-geoman-free@latest/dist/leaflet-geoman.css" />
    <script src="https://unpkg.com/@geoman-io/leaflet-geoman-free@latest/dist/leaflet-geoman.js"></script>

    <!-- // Fullscreen Map assets  -->
    <link rel="stylesheet" href="{{ asset('assets/libs/leaflet/fullscreen/Control.FullScreen.css') }}">
    <script src="{{ asset('assets/libs/leaflet/fullscreen/Control.FullScreen.js') }}"></script>

    <!-- // dataTable for Device lists assets  -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/jquery.dataTables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/select.bootstrap5.css') }}">

    <!-- // Date Picker assets  -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/flatpickr/flatpickr.min.css') }}">
    <script src="{{ asset('assets/js/flat-pickr/jdate.js') }}"></script>
    <script src="{{ asset('assets/js/flat-pickr/flatpickr-jdate.js') }}"></script>
    <script src="{{ asset('assets/js/flat-pickr/l10n/fa-jdate.js') }}"></script>

    <!-- // track player assets  -->
    <script src="{{ asset('assets/libs/leaflet/track-player/leaflet-trackplayer.umd.cjs') }}"></script>
    <script src="{{ asset('assets/libs/leaflet/track-player/rotatedMarker.js') }}"></script>
    <script src="{{ asset('assets/libs/leaflet/track-player/turf.min.js') }}"></script>

    <!-- // Routing Machine assets  -->
    <link rel="stylesheet" href="{{ asset('assets/libs/leaflet/routing-machine/leaflet-routing-machine.css') }}">
    <script src="{{ asset('assets/libs/leaflet/routing-machine/leaflet-routing-machine.min.js') }}"></script>
    <!-- // track player assets  -->
    <script src="{{ asset('assets/libs/leaflet/track-player/leaflet-trackplayer.umd.cjs') }}"></script>
    <script src="{{ asset('assets/libs/leaflet/track-player/rotatedMarker.js') }}"></script>
    <script src="{{ asset('assets/libs/leaflet/track-player/turf.min.js') }}"></script>


    <!-- // Others assets  -->
    <script src="https://unpkg.com/leaflet-polylinedecorator@1.6.0/dist/leaflet.polylinedecorator.js"></script>

    <style>
        #map {
            height: 80vh;
            z-index: 1 !important;
        }

        .route-arrow {
            font-size: 20px;
            color: red;
            text-shadow: 2px 2px 2px white;
        }

        .show-arrows-btn {
            position: absolute;
            top: 58px;
            right: 9px;
            z-index: 1000;
            padding: 10px;
            background: white;
            border: 2px solid #ccc;
            border-radius: 4px;
            cursor: pointer;
        }

        .custom-marker {
            background: none;
            border: none;
        }

        .custom-marker div {
            transition: transform 0.3s ease;
            transform-origin: center center;
        }

        .marker-popup h4 {
            margin: 0 0 8px 0;
            color: #333;
        }

        .marker-popup p {
            margin: 4px 0;
            color: #666;
        }

        .device-sidebar {
            height: 90vh;
        }

        .leaflet-routing-container {
            display: none;
        }

        .leaflet-control-custom {
            background-color: white;
            border: 2px solid gray;
            border-radius: 5px;
            width: 33px;
            height: 33px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer !important;
        }

        .leaflet-control-custom.disabled {
            background-color: lightgray;
            border: 2px solid darkgray;
        }
    </style>
@endassets

@script
    <script>
        // Global States
        //------------------------------------------------------
        Alpine.store('map', {
            map: null,
            defaultLayer: OSMBase,
            mapView: [35.715298, 51.404343],

            initMap() {
                return this.map = L.map(document.getElementById('map'), {
                        pmIgnore: false,
                        fullscreenControl: true,
                    })
                    .setView(this.mapView, 11)
                    .addLayer(this.defaultLayer);
            },

            setMapView(view) {
                this.mapView = view;
            }
        })

        // Track Player
        //------------------------------------------------------
        Alpine.data('trackplayer', () => ({
            track: [],
            trackPlayer: null,
            map: null,
            speeds: [1, 2, 3, 4, 5],
            currentProgress: 0,
            isPlaying: false,
            currentSpeed: 1,

            init() {

                $wire.on('trips-fetched', (locations) => {
                    if (locations.length > 0) {
                        this.map = Alpine.store('map').map;
                        this.prepareTrack(Object.values(locations[0]));
                    }
                })

                this.initializeRangeSlider();
                // window.addEventListener("resize", this.initializeRangeSlider);

            },

            prepareTrack(deviceLocations) {
                this.track = deviceLocations.at(-1).map(location => [
                    parseFloat(location.lat),
                    parseFloat(location.long)
                ]);
            },

            initMap() {
                this.map.setView(this.track[0], 13, {
                    animate: true,
                    duration: 1
                });


                this.trackPlayer = new L.TrackPlayer(this.track, {
                    speed: 600 * this.currentSpeed,
                    markerIcon: L.divIcon({
                        html: `<div><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" x="0" y="0" fill="#0D311B" viewBox="0 0 29 29" xml:space="preserve" width="29" height="29"><style>.st3{fill:#0d311b}</style><path style="fill:#031108" d="M29 14.5A14.5 14.5 0 0 1 14.5 29 14.5 14.5 0 0 1 0 14.5a14.5 14.5 0 0 1 29 0"/><g style="opacity:.2"><path class="st3" d="M14.5 7.613 7.975 22.294l6.525-3.263 6.525 3.263z"/><path class="st3" d="M21.025 22.883c-.091 0-.181 0-.272-.045L14.5 19.711l-6.253 3.127c-.227.136-.498.091-.68-.091s-.227-.453-.136-.68l6.525-14.636a.589.589 0 0 1 1.088 0l6.525 14.636a.63.63 0 0 1-.136.68q-.204.136-.408.136M14.5 18.397c.091 0 .181 0 .272.045l4.984 2.492L14.5 9.153 9.244 20.98l4.984-2.492c.091-.045.181-.091.272-.091"/></g><path style="fill:#fff;stroke:#fff;stroke-width:3;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10" d="M14.5 6.797 8.111 21.161l6.389-3.217 6.389 3.217z"/></svg></div>`,
                        className: 'custom-marker',
                        iconSize: [32, 32],
                    }),
                    markerRotation: true,
                    markerRotationOrigin: 'center'
                }).addTo(this.map);

                this.setupTrackPlayerEvents();
            },

            setupTrackPlayerEvents() {
                this.trackPlayer.on('progress', (progress) => {
                    this.currentProgress = progress * 100;
                    this.initializeRangeSlider()
                });

                this.trackPlayer.on('finished', () => {
                    this.isPlaying = false;
                });
            },

            togglePlay() {
                this.$dispatch('remove-all');

                if (this.isPlaying) {
                    this.trackPlayer.pause();
                    this.isPlaying = false;
                } else {
                    // Reinitialize if not already initialized
                    if (!this.trackPlayer) this.initMap();
                    this.trackPlayer.start();
                    this.isPlaying = true;
                }
            },

            setProgress(value) {
                this.trackPlayer.setProgress(value / 100);
            },

            removeTracker() {
                if (this.trackPlayer) {
                    this.trackPlayer.remove();
                    this.$dispatch('appear-waypoints');
                    this.trackPlayer = null;
                    this.currentProgress = 0;
                    this.currentSpeed = 1;
                    this.track = [];
                    this.isPlaying = false;
                }
            },

            changeSpeed() {
                const speedIndex = (this.speeds.indexOf(this.currentSpeed) + 1) % this.speeds.length;
                this.currentSpeed = this.speeds[speedIndex] === 0 ? 1 : this.speeds[speedIndex];

                if (this.trackPlayer) {
                    this.trackPlayer.setSpeed(600 * this.currentSpeed);
                }
            },

            get displaySpeed() {
                return this.currentSpeed !== 1 ? this.currentSpeed + 'X' : false;
            },

            get btnStatus() {
                return this.track.length > 0;
            },

            initializeRangeSlider() {
                const slider_input = this.$refs.slider_input,
                    slider_thumb = this.$refs.slider_thumb,
                    slider_line = this.$refs.slider_line;

                this.$nextTick(() => {
                    slider_thumb.innerHTML = slider_input.value;
                    const bulletPosition = (slider_input.value / slider_input.max),
                        space = slider_input.offsetWidth - slider_thumb.offsetWidth;

                    slider_thumb.style.left = (bulletPosition * space) + 'px';
                    slider_line.style.width = slider_input.value + '%';
                });
            },

            handleSliderInput(e) {
                let rangeValue = e.target.value;
                this.setProgress(rangeValue);
                this.initializeRangeSlider();
            },
        }))

        // Map
        //------------------------------------------------------
        Alpine.data('mapComponent', () => ({
            map: null,
            baseMaps: baseMaps,
            currentZoom: 16,control: null,
            markers: {},
            savedMarkers: {},
            drownGeofences: {},
            drawnWaypoints: {},
            circleMarkers: [],
            trips: null,
            snapMode: true,
            dirMode: false,
            routeDecorator: null,
            totalDistance: [],


            init() {
                let self = this;
                this.map = Alpine.store('map').initMap();

                L.control.layers(this.baseMaps, null, {
                    position: 'topright'
                }).addTo(this.map);


                this.map.createPane('data-point');
                this.map.getPane('data-point').style.zIndex = 650;

                this.map.on('zoomend', () => this.currentZoom = this.map.getZoom());

                // Fixing Popup when zooming
                L.Popup.prototype._animateZoom = function(e) {
                    if (!this._map) return;
                    let pos = this._map._latLngToNewLayerPoint(this._latlng, e.zoom, e.center),
                        anchor = this._getAnchor();
                    L.DomUtil.setPosition(this._container, pos.add(anchor));
                }


                this.map.pm.setLang("fa");

                // Snap Mode Button
                let snapSvg =
                    '<svg version="1.1" id="Icons" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" xml:space="preserve" width="24" height="24" transform="scale(-1 1)"><style>.st0{fill:none;stroke:#000;stroke-width:2;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10}</style><path class="st0" d="m9.975 5.775 6.075 6.075c1.125 1.125 1.125 2.925 0 4.05s-2.925 1.125-4.05 0L5.925 9.825 2.4 13.35l6.075 6.075c3.075 3.075 8.025 3.075 11.1 0s3.075-8.025 0-11.1L13.5 2.25z"/><path class="st0" d="M2.425 13.343 5.978 9.79l2.015 2.015-3.553 3.553zm7.582-7.572 3.553-3.553 2.015 2.015-3.553 3.553z"/></svg>'
                let snapModeBtn = this.createToggleButton(snapSvg);
                this.map.addControl(new snapModeBtn.object());

                snapModeBtn.button.onclick = () => {
                    this.snapMode = !this.snapMode;

                    if (!this.snapMode) {
                        snapModeBtn.button.classList.remove('enabled');
                        snapModeBtn.button.classList.add('disabled');
                    } else {
                        snapModeBtn.button.classList.remove('disabled');
                        snapModeBtn.button.classList.add('enabled');
                    }

                    if (this.trips) {
                        this.showWaypoints(this.trips);
                    }
                }

                // arrow direction Mode Button
                let directionSvg =
                    '<svg width="24" height="24" viewBox="0 0 0.72 0.72" xmlns="http://www.w3.org/2000/svg"><path d="M.569.168.438.561a.013.013 0 0 1-.026 0L.353.384A.03.03 0 0 0 .336.367L.159.308a.013.013 0 0 1 0-.026L.552.151a.013.013 0 0 1 .017.017" stroke="#464455" stroke-linecap="round" stroke-linejoin="round" stroke-width=".03"/></svg>';
                let dirBtn = this.createToggleButton(directionSvg);
                this.map.addControl(new dirBtn.object());

                dirBtn.button.onclick = () => {
                    this.dirMode = !this.dirMode;

                    if (!this.snapMode) {
                        dirBtn.button.classList.remove('enabled');
                        dirBtn.button.classList.add('disabled');
                    } else {
                        dirBtn.button.classList.remove('disabled');
                        dirBtn.button.classList.add('enabled');
                    }

                    if (this.trips) {
                        this.showWaypoints(this.trips);
                    }
                }


                // Livewire Events
                $wire.on('geo-fetched', (data) => {
                    if (data[0].length > 0) this.showGeofences(data[0]);
                });

                // Initial Map Waypoint
                $wire.on('trips-fetched', (trips) => {
                    if (trips.length > 0) {
                        this.trips = Object.values(trips[0]);
                        this.showWaypoints(Object.values(trips[0]));
                    }
                })

                // Reset
                $wire.on('geo-reset', () => this.removeGeofences())
                $wire.on('trips-reset', () => this.removeWayPoints())


                this.updateLocations($wire.deviceLocations);
                $wire.on('locationUpdated', () => this.updateLocations($wire.deviceLocations));

                setInterval(() => {
                    if ($wire.onlineMode) {
                        $wire.on('locationUpdated', () => this.updateLocations($wire.deviceLocations));
                    }
                }, 4000)
            },

            // Handle The Devices live location
            //-----------------------------------
            updateLocations(locations) {
                // Remove old Markers
                Object.values(this.markers).forEach(marker => marker.remove());
                this.markers = {};

                let bounds = L.latLngBounds();


                // Add New Markers
                Object.entries(locations).forEach(([deviceId, data]) => {
                    if (!data?.lat || !data?.long) return;

                    const position = [parseFloat(data.lat), parseFloat(data.long)];
                    if (isNaN(position[0]) || isNaN(position[1])) return;

                    const status = this.getMarkerStatus(data);
                    const marker = L.marker(position, {
                        icon: this.createCustomIcon(status, parseFloat(JSON.parse(data.device_stats)?.direction))
                    }).bindPopup(this.createPopupContent(data));

                    this.markers[deviceId] = marker;
                    marker.addTo(this.map);
                    bounds.extend(position);
                });

                // Set Map View
                if ($wire.selected.length > 0) {
                    const selectedLocation = locations[$wire.selected.at(-1)];
                    if (selectedLocation) {
                        const position = [parseFloat(selectedLocation.lat), parseFloat(selectedLocation.long)];
                        if (!isNaN(position[0]) && !isNaN(position[1])) {
                            this.map.setView(position, this.currentZoom, {
                                animate: true,
                                duration: 1
                            });
                        }
                    }
                } else if (bounds.isValid()) {
                    this.map.fitBounds(bounds, {
                        padding: [50, 50],
                        maxZoom: 14,
                        animate: true,
                        duration: 1
                    });
                }
            },

            createCustomIcon(status = 'active', degree) {
                const markerIcons = {
                    active: `<svg xmlns="http://www.w3.org/2000/svg" width="32px" height="32px" viewBox="-2 -2 24 24"><path fill="#4CAF50" stroke="#000" stroke-width="2" d="m18.919 2.635l-5.953 16.08c-.376 1.016-1.459 1.538-2.418 1.165a1.85 1.85 0 0 1-1.045-1.054l-1.887-4.77a3.7 3.7 0 0 0-1.955-2.052l-4.542-1.981C.174 9.61-.256 8.465.157 7.465a1.97 1.97 0 0 1 1.067-1.079L16.54.136c.967-.395 2.04.101 2.395 1.109c.157.446.151.94-.015 1.39z"/></svg>`,
                    inactive: `<svg xmlns="http://www.w3.org/2000/svg" width="32px" height="32px" viewBox="-2 -2 24 24"><path fill="#FF5725" stroke="#000" stroke-width="2" d="m18.919 2.635l-5.953 16.08c-.376 1.016-1.459 1.538-2.418 1.165a1.85 1.85 0 0 1-1.045-1.054l-1.887-4.77a3.7 3.7 0 0 0-1.955-2.052l-4.542-1.981C.174 9.61-.256 8.465.157 7.465a1.97 1.97 0 0 1 1.067-1.079L16.54.136c.967-.395 2.04.101 2.395 1.109c.157.446.151.94-.015 1.39z"/></svg>`,
                    warning: `<svg xmlns="http://www.w3.org/2000/svg" width="32px" height="32px" viewBox="-2 -2 24 24"><path fill="#FFC107" stroke="#000" stroke-width="2" d="m18.919 2.635l-5.953 16.08c-.376 1.016-1.459 1.538-2.418 1.165a1.85 1.85 0 0 1-1.045-1.054l-1.887-4.77a3.7 3.7 0 0 0-1.955-2.052l-4.542-1.981C.174 9.61-.256 8.465.157 7.465a1.97 1.97 0 0 1 1.067-1.079L16.54.136c.967-.395 2.04.101 2.395 1.109c.157.446.151.94-.015 1.39z"/></svg>`
                };


                return L.divIcon({
                    html: `<div style="transform: rotate(${Number(degree || 0)}deg);">${markerIcons[status]}</div>`,
                    className: 'custom-marker',
                    iconSize: [32, 32],
                    iconAnchor: [16, 32],
                    popupAnchor: [0, -32]
                });
            },

            createPopupContent(data) {
                return `
            <p style="margin: 0 !important; padding: 3px 0 3px 20px !important; white-space: nowrap; vertical-align: middle !important; text-align: right">
                <span style="margin-left: 5px"><i class="icofont icofont-micro-chip"></i></span>${data.device?.name} - ${data.device?.model}
            </p>
            <p style="margin: 0 !important; padding: 3px 0 3px 20px !important; white-space: nowrap; vertical-align: middle !important; text-align: right">
                <span style="margin-left: 5px"><i class="fa fa-car"></i></span>${data.vehicle?.name || 'نامشخص'}
            </p>
            <p style="margin: 0 !important; padding: 3px 0 3px 20px !important; white-space: nowrap; vertical-align: middle !important; text-align: right">
                <span style="margin-left: 5px"><i class="icofont icofont-bar-code"></i></span>${data.vehicle?.license_plate || 'نامشخص'}
            </p>
            <p style="margin: 0 !important; padding: 3px 0 3px 20px !important; white-space: nowrap; vertical-align: middle !important; text-align: right">
                <span style="margin-left: 5px"><i class="fa fa-user"></i></span>${data.user?.name} - ${data.user?.phone}
            </p>
            <p style="margin: 0 !important; padding: 3px 0 3px 20px !important; white-space: nowrap; vertical-align: middle !important; text-align: right">
                <span style="margin-left: 5px"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clock" style="width: 15px;height: 15px"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg></span>${data.name}
            </p>
            <p style="margin: 0 !important; padding: 3px 0 3px 20px !important; white-space: nowrap; vertical-align: middle !important; text-align: right">
                <span style="margin-left: 5px"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-map-pin" style="width: 15px;height: 15px"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg></span>
                <a href="https://maps.google.com/?q=${data.lat},${data.long}" rel="nofollow noopener noreferrer" target="_blank">${parseFloat(data.lat).toFixed(4)},${parseFloat(data.long).toFixed(4)}</a>
            </p>
            <p style="margin: 0 !important; padding: 3px 0 3px 20px !important; white-space: nowrap; vertical-align: middle !important; text-align: right">
                <span style="margin-left: 5px"><i class="icofont icofont-street-view"></i></span>
                <a href="https://www.google.com/maps?q&layer=c&cbll=${data.lat},${data.long}" rel="nofollow noopener noreferrer" target="_blank">نمایش خیابانی 360 درجه (صفحه جدید)</a>
            </p>
            <p style="margin: 0 !important; padding: 3px 0 3px 20px !important; white-space: nowrap; vertical-align: middle !important; text-align: right">
                <span style="margin-left: 5px"><i class="icofont icofont-speed-meter"></i></span> ${Math.round(JSON.parse(data.device_stats)?.speed || 0)} کیلومتر ‌بر ساعت
            </p>
            ${data.distance ?
                `<p style="margin: 0 !important; padding: 3px 0 3px 20px !important; white-space: nowrap; vertical-align: middle !important; text-align: right">
                                                                                                                                                                                                                                                                                                                                        <span style="margin-left: 5px"><i class="fa fa-solid fa-flag-checkered"></i></span> ${data.distance} کیلومتر
                                                                                                                                                                                                                                                                                                                                    </p>`
                : ''
            }
        `;
            },

            createToggleButton(svgContent, position = 'topleft') {
                let button = L.DomUtil.create('div', 'leaflet-bar leaflet-control leaflet-control-custom');
                button.innerHTML = svgContent;
                button.className = 'enabled';
                button.className = 'leaflet-control-custom';

                button.onclick = function() {
                    if (button.classList.contains('disabled')) {
                        button.classList.remove('disabled');
                        button.classList.add('enabled');
                    } else {
                        button.classList.remove('enabled');
                        button.classList.add('disabled');
                    }
                };

                return {
                    button: button,
                    object: L.Control.extend({
                        onAdd: function(map) {
                            return button;
                        },
                        onRemove: function(map) {
                            // Nothing to do here
                        },
                        getPosition: function() {
                            return position;
                        }
                    })
                };
            },

            getMarkerStatus(data) {
                const lastUpdate = new Date(data.created_at);
                const now = new Date();
                const diffMinutes = Math.floor((now - lastUpdate) / 1000 / 60);

                if (diffMinutes < 5) return 'active';
                if (diffMinutes < 15) return 'warning';
                return 'inactive';
            },

            // Handle geofences
            //-----------------------------------
            showGeofences(geoFences) {
                this.removeGeofences();
                geoFences.forEach(fence => {
                    try {
                        // make Geofence Color
                        const color = this.getColorForGeofence(fence.id);

                        if (fence.points) {
                            const latlngCoordinates = fence.points.map(coord => [coord[1], coord[0]]);
                            const polygon = L.polygon(latlngCoordinates, {
                                color: color
                            }).addTo(this.map);
                            const label = L.marker(polygon.getBounds().getCenter(), {
                                icon: L.divIcon({
                                    className: 'geofence-label',
                                    html: `<span class="fw-bold bg-white d-block p-1 mb-1 text-center rounded">${fence.name}</span>`,
                                    iconSize: [100, 20],
                                })
                            }).addTo(this.map);

                            this.drownGeofences[fence.id] = {
                                polygon
                            };
                            this.drownGeofences[fence.id].label = label;

                        }
                    } catch (error) {
                        console.error("Invalid geometry format:", error);
                    }
                });
            },

            removeGeofences() {
                Object.values(this.drownGeofences).forEach(({
                    polygon,
                    label
                }) => {
                    this.map.removeLayer(polygon);
                    if (label) {
                        this.map.removeLayer(label);
                    }
                });
                this.drownGeofences = {};
            },

            getColorForGeofence(geofenceId) {
                const colors = [
                    "#FF5733", "#33FF57", "#3357FF", "#FF33A1", "#33FFA1", "#A133FF", "#3D27CD", "#DEF61D",
                    "#811414", "#382F18", "#F3D24D", "#3ABA61"
                ];
                const savedColors = JSON.parse(localStorage.getItem('geofenceColors')) || {};

                if (!savedColors[geofenceId]) {
                    savedColors[geofenceId] = colors[Math.floor(Math.random() * colors.length)];
                    localStorage.setItem('geofenceColors', JSON.stringify(savedColors));
                }

                return savedColors[geofenceId];
            },

            // Handle The Devices trips
            //-----------------------------------
            showWaypoints(trips) {

                const startIcon = L.icon({
                    iconUrl: '{{ asset('assets/libs/leaflet/images/map-start.svg') }}',
                    iconSize: [32, 32],
                    iconAnchor: [16, 32],
                    popupAnchor: [0, -32]
                });

                const endIcon = L.icon({
                    iconUrl: '{{ asset('assets/libs/leaflet/images/map-end.svg') }}',
                    iconSize: [32, 32],
                    iconAnchor: [16, 32],
                    popupAnchor: [0, -32]
                });


                this.removeWayPoints();
                this.circleMarkers = []; // Array to store circle markers

                trips.forEach((trip, i) => {
                    const routeCoords = trip.map(coord => [parseFloat(coord.lat), parseFloat(coord
                        .long)]);
                    let polyline, snapedRoute;

                    if (this.snapMode) {
                        snapedRoute = L.Routing.control({
                            waypoints: routeCoords,
                            waypointMode: 'snap',
                            draggableWaypoints: false,
                            routeWhileDragging: false,
                            addWaypoints: false,
                            lineOptions: {
                                styles: [{
                                    color: "#F50A0AFF",
                                    weight: 5,
                                    opacity: this.snapMode ? 0.9 : 0
                                }]
                            },
                            createMarker: function() {},
                        }).addTo(this.map);

                        snapedRoute.on('routesfound', (e) => {
                            const routes = e.routes;

                            if (routes.length > 0) {
                                if (this.dirMode)
                                    this.addRouteDirection(routes[0].coordinates);
                            }

                            // Assign totalDistance to every point in the trip
                            const totalDistance = (routes[0].summary.totalDistance / 1000)
                                .toFixed(2);
                            trip.forEach(point => point.distance = totalDistance);

                        });

                    } else {
                        polyline = L.polyline(routeCoords, {
                            color: "#F50A0AFF",
                            weight: 5,
                            intractive: false,
                            opacity: !this.snapMode ? 0.9 : 0
                        }).addTo(this.map);

                        if (this.dirMode)
                            this.addRouteDirection(polyline.getLatLngs());
                    }


                    const startMarker = L.marker(routeCoords[0], {
                        icon: startIcon,
                        title: 'شروع'
                    }).addTo(this.map);
                    const endMarker = L.marker(routeCoords.at(-1), {
                        icon: endIcon,
                        title: 'پایان'
                    }).addTo(this.map);

                    routeCoords.forEach((coord, i) => {
                        const circle = L.circleMarker(coord, {
                            radius: 5,
                            pane: 'data-point',
                            color: "#3388ff",
                            fillOpacity: 0.5,
                        }).addTo(this.map);

                        circle.on('click', (event) => {
                            const popupContent = this.createPopupContent(trip[i]);
                            L.popup()
                                .setLatLng(event.latlng)
                                .setContent(popupContent)
                                .openOn(this.map);
                        });

                        this.circleMarkers.push(circle);
                    });

                    startMarker.bindPopup(this.createPopupContent(trip[0]));
                    endMarker.bindPopup(this.createPopupContent(trip.at(-1)));

                    this.map.on('zoomend', () => {
                        const currentZoom = this.map.getZoom();
                        this.circleMarkers.forEach((circle) => {
                            if (currentZoom >= 13) {
                                circle.addTo(this.map); // Show circles
                            } else {
                                this.map.removeLayer(circle); // Hide circles
                            }
                        });
                    });

                    this.drawnWaypoints[i] = {
                        polyline: polyline,
                        snapedRoute: snapedRoute
                    };
                    this.drawnWaypoints[i].markers = {
                        startMarker,
                        endMarker,
                    };
                });
            },

            addRouteDirection(route) {
                if (this.routeDecorator) {
                    this.map.removeLayer(this.routeDecorator);
                }

                if (!route) return;

                this.routeDecorator = L.polylineDecorator(route, {
                    patterns: [{
                        repeat: 150,
                        symbol: L.Symbol.arrowHead({
                            pixelSize: 15,
                            pathOptions: {
                                color: '#000',
                                fillOpacity: 0.8,
                                weight: 0
                            }
                        })
                    }]
                }).addTo(this.map);
            },

            removeWayPoints() {

                Object.values(this.drawnWaypoints).forEach((route) => {
                    if (route.polyline) this.map.removeLayer(route.polyline);
                    if (route.snapedRoute) route.snapedRoute.remove();

                    if (route.markers) {
                        Object.values(route.markers).forEach((marker) => {
                            if (marker) this.map.removeLayer(marker);
                        });
                    }

                    if (this.routeDecorator) {
                        this.map.removeLayer(this.routeDecorator);
                    }
                });

                this.circleMarkers.forEach((circle) => {
                    if (circle) this.map.removeLayer(circle);
                });

                this.drawnWaypoints = {};
                this.circleMarkers = [];
            },

        }));


        // DatePicker (Enter Time)
        //------------------------------------------------------
        Alpine.data('dateTimeRange', (input) => ({
            flatpickrInstance: null,
            disabled: true,
            placeholder: 'لطفا ابتدا دستگاه را انتخاب کنید!',

            init() {
                this.initializeFlatpickr();
                this.updateInputState();

                $wire.on('locationUpdated', () => {
                    this.updateInputState();

                    if (this.flatpickrInstance) {
                        this.flatpickrInstance.destroy();
                    }

                    this.initializeFlatpickr();
                });


            },

            updateInputState() {
                if ($wire.selected.length === 0) {
                    this.disabled = true;
                    this.placeholder = 'لطفا ابتدا دستگاه را انتخاب کنید!';
                } else {
                    this.disabled = false;
                    this.placeholder = 'لطفا تاریخ و زمان را انتخاب کنید!';
                }

                if (this.flatpickrInstance) {
                    const altInput = this.flatpickrInstance.altInput;
                    if (altInput) {
                        altInput.disabled = this.disabled;
                        altInput.placeholder = this.placeholder;
                    }
                    this.flatpickrInstance.input.disabled = this.disabled;
                    this.flatpickrInstance.input.placeholder = this.placeholder;
                }
            },

            initializeFlatpickr() {
                this.flatpickrInstance = flatpickr(input, {
                    mode: "range",
                    enableTime: true,
                    time_24hr: true,

                    locale: "fa",
                    altInput: true,
                    altFormat: 'Y/m/d - H:i',
                    maxDate: "today",
                    disableMobile: true,
                    disabled: this.disabled,
                    placeholder: this.placeholder
                });
            }
        }));
    </script>
@endscript
