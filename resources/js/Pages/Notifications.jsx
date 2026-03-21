import React from 'react';
import AppLayout from '../Components/AppLayout';
import { Head, Link } from '@inertiajs/react';
import { Bell, Heart, MessageSquare, UserPlus, AtSign, ChevronRight, Settings } from 'lucide-react';
import { motion } from 'framer-motion';

export default function Notifications() {
    const notifications = [
        { id: 1, type: 'like', user: 'tiktok_star', content: 'liked your video.', time: '2h', avatar: 'https://images.pexels.com/photos/774909/pexels-photo-774909.jpeg?auto=compress&cs=tinysrgb&w=100' },
        { id: 2, type: 'follow', user: 'creative_mind', content: 'started following you.', time: '5h', avatar: 'https://images.pexels.com/photos/1671325/pexels-photo-1671325.jpeg?auto=compress&cs=tinysrgb&w=100' },
        { id: 3, type: 'comment', user: 'v_king', content: 'commented: "This is fire! 🔥"', time: '1d', avatar: 'https://images.pexels.com/photos/3408744/pexels-photo-3408744.jpeg?auto=compress&cs=tinysrgb&w=100' },
        { id: 4, type: 'mention', user: 'trend_setter', content: 'mentioned you in a comment.', time: '2d', avatar: 'https://images.pexels.com/photos/220453/pexels-photo-220453.jpeg?auto=compress&cs=tinysrgb&w=100' },
    ];

    const getIcon = (type) => {
        switch (type) {
            case 'like': return <Heart className="text-red-500 fill-red-500" size={16} />;
            case 'comment': return <MessageSquare className="text-blue-400 fill-blue-400" size={16} />;
            case 'follow': return <UserPlus className="text-primary" size={16} />;
            case 'mention': return <AtSign className="text-purple-400" size={16} />;
            default: return <Bell size={16} />;
        }
    };

    return (
        <AppLayout>
            <Head title="Notifications - AmazamaHub" />

            <div className="max-w-2xl mx-auto w-full py-8 px-4 pb-24 md:pb-8">
                <div className="flex items-center justify-between mb-8">
                    <h1 className="text-2xl font-black italic tracking-tighter">Notifications</h1>
                    <Link href="/settings" className="p-2 hover:bg-gray-900 rounded-full transition">
                        <Settings size={22} className="text-gray-400 hover:text-white" />
                    </Link>
                </div>

                <div className="space-y-1">
                    {/* Filters */}
                    <div className="flex space-x-2 mb-6 overflow-x-auto pb-2 noscrollbar">
                        {['All', 'Likes', 'Comments', 'Mentions', 'Followers'].map((filter, i) => (
                            <button key={i} className={`px-4 py-1.5 rounded-full text-sm font-bold border transition ${i === 0 ? 'bg-white text-black border-white' : 'bg-transparent text-gray-400 border-gray-800 hover:border-gray-600'}`}>
                                {filter}
                            </button>
                        ))}
                    </div>

                    {/* Notification List */}
                    <div className="bg-gray-900/20 rounded-3xl overflow-hidden border border-gray-900/50">
                        {notifications.map((notif) => (
                            <motion.div
                                key={notif.id}
                                whileHover={{ backgroundColor: 'rgba(255, 255, 255, 0.03)' }}
                                className="flex items-center justify-between p-4 border-b border-gray-900/50 last:border-0 cursor-pointer transition group"
                            >
                                <div className="flex items-center space-x-4">
                                    <div className="relative">
                                        <div className="w-12 h-12 rounded-full overflow-hidden border border-gray-800">
                                            <img src={notif.avatar} className="w-full h-full object-cover" alt={notif.user} />
                                        </div>
                                        <div className="absolute -bottom-1 -right-1 bg-black rounded-full p-1 border border-gray-900">
                                            {getIcon(notif.type)}
                                        </div>
                                    </div>
                                    <div className="min-w-0">
                                        <p className="text-sm font-medium">
                                            <span className="font-black italic mr-1">@{notif.user}</span>
                                            <span className="text-gray-300">{notif.content}</span>
                                        </p>
                                        <p className="text-[10px] text-gray-500 font-bold uppercase mt-0.5">{notif.time}</p>
                                    </div>
                                </div>
                                <div className="flex items-center">
                                    {notif.type === 'follow' ? (
                                        <button className="bg-primary text-black text-xs font-black px-4 py-1.5 rounded-md hover:scale-105 active:scale-95 transition">
                                            Follow back
                                        </button>
                                    ) : (
                                        <div className="w-10 h-12 bg-gray-800 rounded overflow-hidden mr-2">
                                            <img src="https://images.pexels.com/photos/1624496/pexels-photo-1624496.jpeg?auto=compress&cs=tinysrgb&w=50" className="w-full h-full object-cover opacity-50" />
                                        </div>
                                    )}
                                    <ChevronRight size={18} className="text-gray-700 group-hover:text-gray-500 transition" />
                                </div>
                            </motion.div>
                        ))}
                    </div>

                    <div className="text-center py-10">
                        <p className="text-xs text-gray-600 font-black uppercase tracking-widest">No more notifications</p>
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}
