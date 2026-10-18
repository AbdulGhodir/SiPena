@extends('layouts.admin')

@section('title', 'Data Anggota')
@section('header_title', 'Data Anggota')
@section('header_subtitle', 'Manajemen anggota perpustakaan')

@section('content')
<div class="space-y-6">

    <div class="flex items-center justify-between gap-4">
        <div class="relative flex items-center">
            <i data-lucide="search" class="w-4 h-4 text-gray-400 absolute left-3.5 pointer-events-none"></i>
            <input
                type="text"
                id="searchMember"
                placeholder="Cari nama atau ID anggota..."
                class="pl-10 pr-4 py-2 bg-white border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#173F35] w-full sm:w-72"
            >
        </div>
    </div>

    <div id="memberGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        @forelse ($members as $member)
        @php
            $initials = collect(explode(' ', trim($member->nama)))
                ->filter()
                ->map(fn($w) => strtoupper(substr($w, 0, 1)))
                ->take(2)
                ->join('');
            if (empty($initials)) { $initials = 'AG'; }

            $memberId = '#' . $member->id;

            $activeBorrowings = $member->borrowings->whereIn('status', ['dipinjam', 'terlambat']);
            $countPinjam = $activeBorrowings->count();
            $hasLate = $activeBorrowings->where('status', 'terlambat')->count() > 0;

            $loansData = $activeBorrowings->map(function($b) {
                $isLate = $b->status === 'terlambat';
                return [
                    'judul' => $b->book->judul ?? 'Buku Tidak Diketahui',
                    'tenggat' => \Carbon\Carbon::parse($b->jatuh_tempo)->locale('id')->translatedFormat('d M Y'),
                    'is_late' => $isLate,
                    'status' => $b->status,
                ];
            })->values();
        @endphp

        <div class="member-card bg-white p-5 rounded-2xl border border-gray-200/60 shadow-xs hover:border-[#173F35]/30 hover:shadow-sm transition flex flex-col justify-between gap-5"
            data-nama="{{ strtolower($member->nama) }}"
            data-code="{{ $member->id }}"
        >
            <div class="flex items-center gap-3.5">
                <div class="w-12 h-12 rounded-full bg-[#173F35] text-[#F4E8CD] font-bold flex items-center justify-center text-sm shrink-0">
                    {{ $initials }}
                </div>
                <div class="min-w-0">
                    <h3 class="member-nama-text font-bold text-[#173F35] text-base leading-snug truncate">{{ $member->nama }}</h3>
                    <p class="member-code-text text-xs text-gray-400 font-medium mt-0.5">ID: #{{ $member->id }}</p>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-2 pt-4 border-t border-gray-100">
                <div>
                    <span class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider block">STATUS</span>
                    <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-emerald-600 mt-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                        <span>Aktif</span>
                    </span>
                </div>
                <div>
                    <span class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider block text-right">PINJAMAN AKTIF</span>
                    @if ($countPinjam > 0)
                        <span class="text-xs font-semibold text-right block mt-1 {{ $hasLate ? 'text-red-600' : 'text-[#173F35]' }}">
                            {{ $countPinjam }} Buku {{ $hasLate ? '(Jatuh Tempo)' : '' }}
                        </span>
                    @else
                        <span class="text-xs font-semibold text-gray-400 text-right block mt-1">
                            0 Buku
                        </span>
                    @endif
                </div>
            </div>

            <button
                type="button"
                onclick='openMemberDrawer({
                    nama: @json($member->nama),
                    initials: @json($initials),
                    code: @json("#" . $member->id),
                    email: @json($member->email),
                    phone: @json($member->no_tlp ?? "-"),
                    joined: @json($member->created_at ? \Carbon\Carbon::parse($member->created_at)->locale("id")->translatedFormat("d M Y") : "-"),
                    countPinjam: @json($countPinjam),
                    loans: @json($loansData)
                })'
                class="w-full py-2.5 border border-[#173F35] text-[#173F35] hover:bg-[#173F35] hover:text-white rounded-xl text-xs font-semibold transition cursor-pointer text-center"
            >
                Lihat Profil Anggota
            </button>
        </div>
        @empty
        <div class="col-span-full bg-white p-12 rounded-2xl border border-gray-200/60 text-center">
            <div class="flex flex-col items-center gap-2 text-gray-400">
                <i data-lucide="users" class="w-10 h-10 text-gray-300"></i>
                <span class="text-sm font-medium">Belum ada anggota terdaftar</span>
            </div>
        </div>
        @endforelse
    </div>

</div>

<div id="drawerBackdrop" class="fixed inset-0 bg-black/40 z-40 hidden transition-opacity" onclick="closeMemberDrawer()"></div>

<div id="memberDrawer" class="fixed top-0 right-0 h-full w-full max-w-md bg-white z-50 shadow-2xl flex flex-col justify-between translate-x-full transition-transform duration-300 ease-in-out">
    <div class="p-6 border-b border-gray-100 flex items-center justify-between shrink-0">
        <h3 class="text-lg font-bold text-[#173F35]">Profil Anggota</h3>
        <button type="button" onclick="closeMemberDrawer()" class="text-gray-400 hover:text-gray-700 p-1 rounded-lg cursor-pointer transition">
            <i data-lucide="x" class="w-5 h-5"></i>
        </button>
    </div>

    <div class="p-6 overflow-y-auto space-y-6 flex-1">
        <div class="text-center space-y-2">
            <div id="drawerMemberInitials" class="w-20 h-20 mx-auto rounded-full bg-[#173F35] text-[#F4E8CD] font-bold text-2xl flex items-center justify-center ring-4 ring-gray-100">
                --
            </div>
            <div>
                <h2 id="drawerMemberName" class="text-xl font-bold text-[#173F35]"></h2>
                <div class="flex justify-center mt-1">
                    <span id="drawerMemberCode" class="px-3 py-0.5 rounded-full text-xs font-semibold bg-[#FCFAF5] text-[#52796F] border border-gray-200"></span>
                </div>
            </div>
        </div>

        <div class="bg-[#FCFAF5] p-4 rounded-2xl border border-gray-200/60 space-y-3 text-xs text-gray-600">
            <div class="flex items-center gap-3">
                <i data-lucide="mail" class="w-4 h-4 text-[#52796F] shrink-0"></i>
                <span id="drawerMemberEmail" class="truncate font-medium text-gray-700"></span>
            </div>
            <div class="flex items-center gap-3">
                <i data-lucide="phone" class="w-4 h-4 text-[#52796F] shrink-0"></i>
                <span id="drawerMemberPhone" class="font-medium text-gray-700"></span>
            </div>
            <div class="flex items-center gap-3">
                <i data-lucide="calendar" class="w-4 h-4 text-[#52796F] shrink-0"></i>
                <span>Bergabung sejak <strong id="drawerMemberJoined" class="text-gray-700 font-semibold"></strong></span>
            </div>
        </div>

        <div class="space-y-3">
            <div class="flex items-center justify-between">
                <h4 class="text-sm font-bold text-[#173F35]">Sedang Dipinjam</h4>
                <span id="drawerMemberLoanCount" class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-[#FCFAF5] text-[#173F35] border border-gray-200"></span>
            </div>

            <div id="drawerLoansList" class="space-y-2.5">
            </div>
        </div>
    </div>
</div>



<script>
    function openMemberDrawer(data) {
        document.getElementById('drawerMemberInitials').innerText = data.initials;
        document.getElementById('drawerMemberName').innerText = data.nama;
        document.getElementById('drawerMemberCode').innerText = data.code;
        document.getElementById('drawerMemberEmail').innerText = data.email;
        document.getElementById('drawerMemberPhone').innerText = data.phone;
        document.getElementById('drawerMemberJoined').innerText = data.joined;
        document.getElementById('drawerMemberLoanCount').innerText = data.countPinjam + ' Buku';

        const listContainer = document.getElementById('drawerLoansList');
        listContainer.innerHTML = '';

        if (!data.loans || data.loans.length === 0) {
            listContainer.innerHTML = '<div class="p-6 text-center text-xs text-gray-400 bg-[#FCFAF5] rounded-xl border border-dashed border-gray-200">Tidak ada pinjaman aktif</div>';
        } else {
            data.loans.forEach(loan => {
                const item = document.createElement('div');
                item.className = 'p-3.5 bg-white border border-gray-200/80 rounded-2xl flex items-center justify-between gap-3 shadow-2xs';
                item.innerHTML = `
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-[#173F35] text-[#F4E8CD] flex items-center justify-center shrink-0">
                            <i data-lucide="book" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <h5 class="font-bold text-xs text-[#173F35] line-clamp-1">${loan.judul}</h5>
                            <p class="text-[11px] text-gray-500 mt-0.5">Tenggat: ${loan.tenggat}</p>
                            ${loan.is_late
                                ? '<span class="inline-block mt-1 px-2 py-0.5 rounded bg-red-50 text-red-600 text-[10px] font-semibold border border-red-100">Terlambat</span>'
                                : '<span class="inline-block mt-1 px-2 py-0.5 rounded bg-emerald-50 text-emerald-700 text-[10px] font-semibold border border-emerald-100">Dipinjam</span>'
                            }
                        </div>
                    </div>
                    <div class="text-gray-400">
                        <i data-lucide="repeat" class="w-4 h-4"></i>
                    </div>
                `;
                listContainer.appendChild(item);
            });
        }

        const drawer = document.getElementById('memberDrawer');
        const backdrop = document.getElementById('drawerBackdrop');

        backdrop.classList.remove('hidden');
        setTimeout(() => {
            drawer.classList.remove('translate-x-full');
        }, 10);

        if (window.lucide) {
            window.lucide.createIcons();
        }
    }

    function closeMemberDrawer() {
        const drawer = document.getElementById('memberDrawer');
        const backdrop = document.getElementById('drawerBackdrop');

        drawer.classList.add('translate-x-full');
        setTimeout(() => {
            backdrop.classList.add('hidden');
        }, 300);
    }



    document.getElementById('searchMember').addEventListener('input', function () {
        const q = this.value.toLowerCase();
        document.querySelectorAll('.member-card').forEach(card => {
            const nama = card.getAttribute('data-nama') || '';
            const code = card.getAttribute('data-code') || '';
            card.style.display = (nama.includes(q) || code.includes(q)) ? '' : 'none';
        });
    });
</script>
@endsection
