<div x-data="handleTableUsers()" class="w-full h-full overflow-hidden p-4 mt-2">
    <div class="w-full h-fit bg-white dark:bg-darker shadow-lg rounded-sm">
        <div class="grid md:grid-cols-2 grid-cols-1 border-b dark:border-primary-darker">

            {{-- Search Users --}}
            <div class="flex items-center justify-start px-5 py-4">
                <form action="" method="GET">
                    <div class="flex items-center space-x-3">
                        <x-form.input type="text" name="searchUser" inputName="search_user" label=""
                            placeholder="Search User by Name..." />
                        <button type="submit" class="py-1.5 mt-2 px-2 bg-primary rounded text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                            </svg>
                        </button>
                    </div>
                </form>
            </div>

            <div
                class="px-5 py-4 border-b dark:border-primary-darker md:flex md:items-center md:justify-end md:space-x-3 space-y-2">
                <div>
                    <button x-show="showBtn" x-transition.duration.500ms
                        class="w-fit bg-red-500 hover:bg-red-600 text-white md:p-1.5 md:px-4 p-1 px-2 md:mt-2 mt-0 rounded cursor-pointer"
                        id="btnDeleteAllRecords" type="submit">
                        <span class="md:text-md text-sm uppercase">deleted selected users</span>
                    </button>
                </div>
            </div>

        </div>
        <div class="px-5 py-4 flex items-center justify-between">
          <div>
            @foreach ($roles as $role)
              <a href="?role_id={{ $role->id }}"
              class="bg-primary-100 rounded-md w-fit h-auto p-2 text-xs font-semibold
              text-primary">{{ $role->role_name }}</a>
            @endforeach
          </div>
          <div class="w-52">
            <select name="filter_by" id="filtered_user" @change="filteredBy($event)">
              <option selected disabled value="">Filter By</option>
              <option value="online_user" @if (request()->query('filter-by') === 'online_user') {{ 'selected' }} @endif>Online User</option>
              <option value="offline_user" @if (request()->query('filter-by') === 'offline_user') {{ 'selected' }} @endif>Offline User</option>
              <option value="active_user" @if (request()->query('filter-by') === 'active_user') {{ 'selected' }} @endif>Active User</option>
              <option value="deactive_user" @if (request()->query('filter-by') === 'deactive_user') {{ 'selected' }} @endif>Deactive User</option>
            </select>
          </div>
        </div>

        <div class="overflow-x-auto p-3">
            <table class="w-full">
                <thead
                    class="text-xs font-semibold uppercase text-white dark:text-light bg-primary hover:bg-primary-dark">
                    <tr>
                        <th></th>
                        <th class="p-2">
                            <div class="font-semibold text-left">Fullname</div>
                        </th>
                        <th class="p-2">
                            <div class="font-semibold text-left">Username</div>
                        </th>
                        <th class="p-2">
                            <div class="font-semibold text-center">Role</div>
                        </th>
                        <th class="p-2">
                            <div class="font-semibold text-center">Status Active</div>
                        </th>
                        <th class="p-2">
                            <div class="font-semibold text-center">Status Online</div>
                        </th>
                        <th class="p-2">
                            <div class="font-semibold text-center">IP Address</div>
                        </th>
                        <th class="p-2">
                            <div class="font-semibold text-center">Last Logout At</div>
                        </th>
                        <th class="p-2">
                            <div class="font-semibold text-center">Created At</div>
                        </th>
                        <th class="p-2">
                            <div class="font-semibold text-center">Action</div>
                        </th>
                    </tr>
                </thead>

                <tbody
                    class="text-sm text-primary dark:text-primary-light divide-y divide-gray-100 dark:divide-primary">
                    @if (count($users))
                    @foreach ($users as $user)
                    <tr>
                        <td class="p-2">
                            <input type="checkbox" autocomplete="off" name="checked_record_ids" x-model="selectedRecord"
                                id="selected_items" @change="updateBtnVisibillity()"
                                class="w-4 h-4 text-blue-600 bg-gray-100 rounded focus:ring-blue-500 dark:focus:ring-blue-600 focus:ring-2 dark:bg-primary-dark cursor-pointer"
                                value="{{ $user->id }}" />
                        </td>
                        <td class="p-2">
                            <div class="font-medium">
                                {{ $user->fullname }}
                            </div>
                        </td>
                        <td class="p-2">
                            <div class="font-medium">
                                {{ $user->username }}
                            </div>
                        </td>
                        <td class="p-2">
                            @php
                            $bgBtnRole = '';
                            $colorTextRole = '';
                            switch ($user->role->role_name) {
                            case 'CEO & Founder':
                            $bgBtnRole = 'bg-green-100';
                            $colorTextRole = 'text-green-500';
                            break;
                            case 'Admin':
                            $bgBtnRole = 'bg-blue-100';
                            $colorTextRole = 'text-blue-500';
                            break;
                            case 'Member':
                            $bgBtnRole = 'bg-yellow-100';
                            $colorTextRole = 'text-yellow-500';
                            break;
                            case 'Writter':
                            $bgBtnRole = 'bg-violet-100';
                            $colorTextRole = 'text-violet-500';
                            break;
                            }
                            @endphp
                            <div class="text-center">
                                <button type="button"
                                    class="w-fit h-auto p-1 px-2 {{ $bgBtnRole }} font-semibold {{ $colorTextRole }} text-xs rounded">
                                    {{ $user->role->role_name }}
                                </button>
                            </div>
                        </td>
                        <td class="p-2 text-center">
                            <div>
                                <button type="button"
                                    class="w-fit h-auto p-1 px-3 {{ $user->status_active ? 'bg-green-100' : 'bg-rose-100' }} font-semibold {{ $user->status_active ? 'text-green-500' : 'text-rose-500' }} text-sm rounded">
                                    {{ $user->status_active ? 'Active' : 'Inactive' }}
                                </button>
                            </div>
                        </td>
                        <td class="p-2 text-center">
                            <div>
                                <button type="button"
                                    class="w-fit h-auto p-1 px-3 {{ $user->status_online ? 'bg-green-100' : 'bg-rose-100' }} font-semibold {{ $user->status_online ? 'text-green-500' : 'text-rose-500' }} text-sm rounded">
                                    {{ $user->status_online ? 'Online' : 'Offline' }}
                                </button>
                            </div>
                        </td>
                        <td class="p-2">
                            <div class="font-semibold text-center">
                                {{ $user->ip_user }}
                            </div>
                        </td>
                        <td class="p-2">
                            <div class="text-center font-medium text-rose-500">
                                {{ \Carbon\Carbon::parse($user->last_seen)->format("d F Y H:i:s") }}
                            </div>
                        </td>
                        <td class="p-2">
                            <div class="text-center font-medium text-green-500">
                                {{ $user->created_at->format("d F Y H:i:s") }}
                            </div>
                        </td>
                        <td>
                            aksi
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <div class="mt-2 mb-3">
                        <p class="text-2xl text-rose-400 text-center capitalize dark:text-primary-light">User Not Found</p>
                    </div>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@push('dashboard-js')
<script>
    new SlimSelect({
        select: '#filtered_user',
         settings: {
          showSearch: false,
        }
    })
    function handleTableUsers() {
        return {
            showBtn: false,
            selectedRecord: [],

            updateBtnVisibillity() {
                this.showBtn = this.selectedRecord.length > 0
            },

            filteredBy(event) {
              const selectedFilter = event.currentTarget.value
              if (selectedFilter) {
                window.location.href = `?filter-by=${selectedFilter}`
              }
            }
        }
    }

</script>
@endpush
