import React from 'react';
import Navbar from './Navbar';
import Sidebar from './Sidebar';
import { Link, usePage } from '@inertiajs/react';
import { Home, Compass, Plus, MessageSquare, User, Search, Bell, Users, ShoppingBag } from 'lucide-react';

export default function AppLayout({ children }) {
    const { props } = usePage();
    const user = props.auth?.user;

    return (
        <div className="bg-black text-white h-screen flex flex-col overflow-hidden">
            <Navbar user={user} />

            <div className="flex flex-1 overflow-hidden max-w-[1600px] mx-auto w-full relative">
                {/* Desktop Left Sidebar */}
                <div className="hidden lg:block w-72 h-full">
                    <Sidebar user={user} />
                </div>

                {/* Mobile/Small Screen Mini Sidebar */}
                <div className="hidden md:flex lg:hidden w-20 flex-col items-center py-4 space-y-8 h-full bg-black border-r border-gray-900">
                    <Link href="/"><Home size={32} className="text-primary cursor-pointer hover:scale-110 transition" /></Link>
                    <Link href="/explore"><Compass size={32} className="text-white cursor-pointer hover:scale-110 transition" /></Link>
                    <Link href="/upload"><Plus size={32} className="text-white cursor-pointer hover:scale-110 transition" /></Link>
                    <Link href="/messages" className="relative group">
                        <MessageSquare size={32} className="text-white cursor-pointer hover:scale-110 transition" />
                        {props.auth.unread_messages_count > 0 && (
                            <span className="absolute -top-1 -right-1 bg-primary text-black text-[10px] w-5 h-5 flex items-center justify-center rounded-full font-black border-2 border-black">
                                {props.auth.unread_messages_count}
                            </span>
                        )}
                    </Link>
                    <Link href={user ? `/profile/@${user.username}` : '/profile'}><User size={32} className="text-white cursor-pointer hover:scale-110 transition" /></Link>
                </div>

                {/* Main Content Area */}
                <main className="flex-1 relative flex flex-col min-w-0 overflow-y-auto custom-scrollbar">
                    {children}
                </main>
            </div>

            {/* Mobile Bottom Navigation (Visible on small screens only) */}
            <div className="md:hidden border-t border-gray-800 h-16 bg-black flex justify-around items-center px-4 fixed bottom-0 left-0 right-0 z-50">
                <Link href="/" className="text-white flex flex-col items-center">
                    <Home size={24} />
                    <span className="text-[10px] mt-1 font-bold">Home</span>
                </Link>
                <Link href="/friends" className="text-gray-400 flex flex-col items-center">
                    <Users size={24} />
                    <span className="text-[10px] mt-1">Friends</span>
                </Link>
                <Link href="/shop" className="text-gray-400 flex flex-col items-center">
                    <ShoppingBag size={24} />
                    <span className="text-[10px] mt-1">Shop</span>
                </Link>
                <Link href="/story" className="relative group mx-2">
                    <div className="bg-white rounded-lg px-3 py-1.5 flex items-center justify-center relative z-10">
                        <Plus size={20} className="text-black" />
                    </div>
                    <div className="absolute inset-0 bg-primary -left-1 rounded-lg"></div>
                    <div className="absolute inset-0 bg-cyan-400 -right-1 rounded-lg"></div>
                </Link>
                <Link href="/notifications" className="text-gray-400 flex flex-col items-center relative">
                    <Bell size={24} />
                    {props.auth.unread_messages_count > 0 && (
                        <span className="absolute -top-1 right-2 bg-primary text-black text-[9px] w-4 h-4 flex items-center justify-center rounded-full font-black border border-black">
                            {props.auth.unread_messages_count}
                        </span>
                    )}
                    <span className="text-[10px] mt-1">Inbox</span>
                </Link>
                <Link href={user ? `/profile/@${user.username}` : '/profile'} className="text-gray-400 flex flex-col items-center">
                    <User size={24} />
                    <span className="text-[10px] mt-1">Profile</span>
                </Link>
            </div>
        </div>
    );
}
