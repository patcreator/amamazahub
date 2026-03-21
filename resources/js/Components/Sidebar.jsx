import React from 'react';
import { Link } from '@inertiajs/react';
import { Home, Compass, Upload, MessageSquare, User, LogIn, Users, CheckCircle2, Radio, ShoppingBag, Settings } from 'lucide-react';
import { usePage } from '@inertiajs/react';

export default function Sidebar({ user }) {
    const { url, props } = usePage();
    const { auth } = props;

    const menus = [
        { name: 'Home', icon: <Home size={28} />, href: '/' },
        { name: 'Explore', icon: <Compass size={28} />, href: '/explore' },
        { name: 'Shop', icon: <ShoppingBag size={28} />, href: '/shop' },
        { name: 'Upload', icon: <Upload size={28} />, href: '/upload' },
        { name: 'Messages', icon: <MessageSquare size={28} />, href: '/messages' },
        { name: 'Following', icon: <Users size={28} />, href: '/following' },
        { name: 'LIVE', icon: <Radio size={28} />, href: '/live' },
        { name: 'Friends', icon: <Users size={28} />, href: '/friends' },
        { name: 'Profile', icon: <User size={28} />, href: user ? `/profile/@${user.username}` : '/profile' },
        { name: 'Settings', icon: <Settings size={28} />, href: '/settings' },
    ];


    const isActive = (href) => {
        if (href === '/' && url === '/') return true;
        if (href !== '/' && url.startsWith(href)) return true;
        return false;
    };

    return (
        <div className="p-4 space-y-2 h-full bg-black overflow-y-auto custom-scrollbar">
            <div className="space-y-1">
                {menus.map((item) => (
                    <Link
                        key={item.name}
                        href={item.href}
                        className={`flex items-center justify-between w-full p-3 rounded-lg font-bold text-lg hover:bg-gray-900/50 transition group ${isActive(item.href) ? 'text-primary bg-primary/5' : 'text-white'}`}
                    >
                        <div className="flex items-center space-x-4 relative">
                            <span className={isActive(item.href) ? 'text-primary' : 'text-white group-hover:text-primary transition-colors'}>
                                {item.icon}
                                {item.name === 'Messages' && auth.unread_messages_count > 0 && (
                                    <span className="absolute -top-1 -left-1 bg-primary text-black text-[10px] w-5 h-5 flex items-center justify-center rounded-full font-black border-2 border-black">
                                        {auth.unread_messages_count}
                                    </span>
                                )}
                            </span>
                            <span className="hidden lg:block">{item.name}</span>
                        </div>
                        {item.name === 'LIVE' && (
                            <span className="hidden lg:block bg-primary text-black text-[10px] px-1.5 py-0.5 rounded font-black italic">LIVE</span>
                        )}
                    </Link>
                ))}
            </div>

            {!user && (
                <div className="border-t border-gray-800 my-4 pt-4 px-2 hidden lg:block">
                    <p className="text-gray-500 text-sm font-medium leading-relaxed">Log in to follow creators, like videos, and view comments.</p>
                    <Link href="/login" className="mt-4 w-full border border-primary text-primary font-bold py-3 rounded-md hover:bg-primary/10 transition flex items-center justify-center space-x-2">
                        <LogIn size={20} />
                        <span>Log in</span>
                    </Link>
                </div>
            )}

            {/* Suggested accounts */}
            <div className="border-t border-gray-800 my-4 pt-4 px-2 hidden lg:block overflow-hidden">
                <p className="text-gray-500 text-sm font-bold uppercase tracking-wider mb-4 px-1">Suggested accounts</p>
                <div className="space-y-3">
                    {[
                        { name: 'TikTok Star', username: 'tiktok_star', avatar: 'https://images.pexels.com/photos/774909/pexels-photo-774909.jpeg?auto=compress&cs=tinysrgb&w=100' },
                        { name: 'Creative Mind', username: 'creative', avatar: 'https://images.pexels.com/photos/1671325/pexels-photo-1671325.jpeg?auto=compress&cs=tinysrgb&w=100' },
                        { name: 'Viral King', username: 'v_king', avatar: 'https://images.pexels.com/photos/3408744/pexels-photo-3408744.jpeg?auto=compress&cs=tinysrgb&w=100' },
                    ].map((acc, i) => (
                        <div key={i} className="flex items-center space-x-3 p-2 hover:bg-gray-900/50 rounded-md cursor-pointer transition group">
                            <div className="w-8 h-8 rounded-full overflow-hidden bg-gray-800 flex-shrink-0 border border-gray-800">
                                <img src={acc.avatar} className="w-full h-full object-cover" alt={acc.username} />
                            </div>
                            <div className="flex-1 min-w-0">
                                <div className="flex items-center space-x-1">
                                    <p className="text-sm font-black truncate">{acc.username}</p>
                                    <CheckCircle2 className="text-blue-400 fill-blue-400/20 flex-shrink-0" size={14} />
                                </div>
                                <p className="text-[10px] text-gray-500 truncate font-semibold">{acc.name}</p>
                            </div>
                        </div>
                    ))}
                    <button className="text-primary text-xs font-black px-2 mt-2 hover:underline">See all</button>
                </div>
            </div>

            <div className="space-y-4 text-xs text-gray-500 font-semibold px-2 py-4 hidden lg:block">
                <div className="flex flex-wrap gap-2">
                    <span>About</span><span>Newsroom</span><span>Contact</span><span>Careers</span>
                </div>
                <div className="flex flex-wrap gap-2">
                    <span>Amazama for Good</span><span>Advertise</span><span>Developers</span>
                </div>
                <div className="flex flex-wrap gap-2">
                    <Link href="/help" className="hover:underline">Help</Link>
                    <Link href="/safety" className="hover:underline">Safety</Link>
                    <Link href="/guidelines" className="hover:underline">Terms</Link>
                    <Link href="/privacy" className="hover:underline">Privacy</Link>
                </div>
                <p className="pt-2">© 2026 AmazamaHub</p>
            </div>
        </div>
    );
}
