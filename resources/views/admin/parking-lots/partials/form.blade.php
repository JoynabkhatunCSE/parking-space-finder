<div class="space-y-3">
    <input name="name"
           value="{{ old('name', $parkingLot->name ?? '') }}"
           placeholder="Name"
           class="w-full border p-2">

    <textarea name="address"
              placeholder="Address"
              class="w-full border p-2">{{ old('address', $parkingLot->address ?? '') }}</textarea>

    <input name="latitude"
           value="{{ old('latitude', $parkingLot->latitude ?? '') }}"
           placeholder="Latitude"
           class="w-full border p-2">

    <input name="longitude"
           value="{{ old('longitude', $parkingLot->longitude ?? '') }}"
           placeholder="Longitude"
           class="w-full border p-2">

    <input name="total_spaces"
           value="{{ old('total_spaces', $parkingLot->total_spaces ?? '') }}"
           placeholder="Total Spaces"
           class="w-full border p-2">

    <input name="hourly_rate"
           value="{{ old('hourly_rate', $parkingLot->hourly_rate ?? '') }}"
           placeholder="Hourly Rate"
           class="w-full border p-2">
</div>
