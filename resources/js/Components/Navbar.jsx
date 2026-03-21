import React, { useState } from 'react';
import { Search, Plus, MessageSquare, Bell, User, LogIn, LogOut, Settings, LayoutDashboard, Wallet, Radio, HelpCircle } from 'lucide-react';
import { Link, usePage } from '@inertiajs/react';

export default function Navbar({ user }) {
    const { auth } = usePage().props;
    const [showDropdown, setShowDropdown] = useState(false);

    return (
        <nav className="h-16 border-b border-gray-800 flex items-center justify-between px-4 md:px-8 bg-black/80 backdrop-blur-xl sticky top-0 z-50">
            {/* Logo */}
            <Link href="/" className="flex items-center space-x-2 group">
                <div className="w-10 h-10 bg-gradient-to-tr from-primary to-cyan-400 rounded-lg flex items-center justify-center p-1.5 shadow-lg shadow-primary/20 group-hover:scale-110 transition duration-300">
                    <svg viewBox="0 0 24 24" className="w-full h-full text-black fill-current stroke-black" strokeWidth="2">
                        <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" />
                    </svg>
                </div>
                <h1 className="text-2xl font-black italic tracking-tighter hover:text-primary transition duration-300">AMAZAMAHUB</h1>
            </Link>

            {/* Search */}
            <form action="/search" className="hidden md:flex flex-1 max-w-md mx-8">
                <div className="relative w-full group">
                    <input
                        type="text"
                        name="q"
                        placeholder="Search amazing videos"
                        className="w-full bg-gray-900/50 border border-gray-800 rounded-full py-2.5 px-6 pl-12 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition duration-300 group-hover:bg-gray-800/80"
                    />
                    <Search className="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 group-hover:text-gray-300 transition duration-300" size={20} />
                </div>
            </form>

            {/* Actions */}
            <div className="flex items-center space-x-4">
                <Link href="/upload" className="flex items-center space-x-2 bg-gray-900 border border-gray-800 px-4 py-2 rounded-md font-bold hover:bg-gray-800 transition transform active:scale-95 group">
                    <Plus size={20} className="group-hover:text-primary" />
                    <span className="hidden sm:inline">Upload</span>
                </Link>

                {user ? (
                    <div className="flex items-center space-x-6 px-2">
                        <Link href="/messages" className="text-white hover:text-primary transition relative">
                            <MessageSquare size={24} />
                            {auth.unread_messages_count > 0 && (
                                <span className="absolute -top-1 -right-1 bg-primary text-black text-[10px] font-black rounded-full w-4 h-4 flex items-center justify-center">
                                    {auth.unread_messages_count}
                                </span>
                            )}
                        </Link>
                        <Link href="/notifications" className="text-white hover:text-primary transition">
                            <Bell size={24} />
                        </Link>

                        <div className="relative">
                            <button
                                onClick={() => setShowDropdown(!showDropdown)}
                                className="w-10 h-10 rounded-full bg-primary/20 border-2 border-primary flex items-center justify-center overflow-hidden hover:scale-105 transition"
                            >
                                {user.avatar ? <img src={user.avatar} className="w-full h-full object-cover" /> : <span className="font-bold">{user.name[0]}</span>}
                            </button>

                            {showDropdown && (
                                <div className="absolute right-0 mt-3 w-56 bg-gray-950 border border-gray-800 rounded-2xl shadow-2xl py-2 z-50 animate-in fade-in slide-in-from-top-2 duration-300">
                                    <Link href={`/profile/@${user.username}`} className="flex items-center space-x-3 px-4 py-3 hover:bg-white/5 transition">
                                        <User size={18} /> <span className="text-sm font-bold">View profile</span>
                                    </Link>
                                    <Link href="/wallet" className="flex items-center space-x-3 px-4 py-3 hover:bg-white/5 transition">
                                        <Wallet size={18} /> <span className="text-sm font-bold">Get Coins</span>
                                    </Link>
                                    <Link href="/creator-tools" className="flex items-center space-x-3 px-4 py-3 hover:bg-white/5 transition">
                                        <LayoutDashboard size={18} /> <span className="text-sm font-bold">Creator tools</span>
                                    </Link>
                                    <Link href="/settings" className="flex items-center space-x-3 px-4 py-3 hover:bg-white/5 transition">
                                        <Settings size={18} /> <span className="text-sm font-bold">Settings</span>
                                    </Link>
                                    <div className="border-t border-gray-800 my-1"></div>
                                    <Link href="/help" className="flex items-center space-x-3 px-4 py-3 hover:bg-white/5 transition">
                                        <HelpCircle size={18} /> <span className="text-sm font-bold">Feedback and help</span>
                                    </Link>
                                    <Link method="post" href="/logout" as="button" className="w-full flex items-center space-x-3 px-4 py-3 hover:bg-white/5 transition text-red-400">
                                        <LogOut size={18} /> <span className="text-sm font-bold">Log out</span>
                                    </Link>
                                </div>
                            )}
                        </div>
                    </div>
                ) : (
                    <div className="flex items-center space-x-4">
                        <Link href="/login" className="bg-primary text-black font-black px-6 py-2 rounded-md hover:bg-primary/90 transition transform hover:scale-105 active:scale-95 shadow-lg shadow-primary/20">
                            Log in
                        </Link>
                    </div>
                )}
            </div>
        </nav>
    );
}
