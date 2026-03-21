import React from 'react';
import AppLayout from '../Components/AppLayout';
import { Head } from '@inertiajs/react';
import { Users, UserPlus, MessageCircle, Heart, Share2, Music } from 'lucide-react';
import { motion } from 'framer-motion';

export default function Friends() {
    const friends = [
        { id: 1, user: 'alex_vibes', lastActive: '2m', avatar: 'https://images.pexels.com/photos/220453/pexels-photo-220453.jpeg?auto=compress&cs=tinysrgb&w=100' },
        { id: 2, user: 'marta_designs', lastActive: 'Active now', avatar: 'https://images.pexels.com/photos/415829/pexels-photo-415829.jpeg?auto=compress&cs=tinysrgb&w=100' },
        { id: 3, user: 'josh_fitness', lastActive: '1h', avatar: 'https://images.pexels.com/photos/1222271/pexels-photo-1222271.jpeg?auto=compress&cs=tinysrgb&w=100' },
    ];

    return (
        <AppLayout>
            <Head title="Friends - AmazamaHub" />

            <div className="max-w-2xl mx-auto w-full py-8 px-4 pb-24 md:pb-8">
                <div className="flex items-center justify-between mb-8">
                    <h1 className="text-2xl font-black italic tracking-tighter">Friends</h1>
                    <button className="p-2 border border-gray-800 rounded-full hover:bg-gray-900 transition"><UserPlus size={20} className="text-gray-400" /></button>
                </div>

                {/* Friends Bar */}
                <div className="flex space-x-6 overflow-x-auto pb-8 noscrollbar">
                    {friends.map((friend) => (
                        <div key={friend.id} className="flex flex-col items-center space-y-2 flex-shrink-0 cursor-pointer group">
                            <div className="relative">
                                <div className="w-16 h-16 rounded-full p-0.5 border-2 border-primary group-hover:scale-110 transition duration-300">
                                    <img src={friend.avatar} className="w-full h-full rounded-full object-cover" />
                                </div>
                                {friend.lastActive === 'Active now' && (
                                    <div className="absolute bottom-1 right-1 w-4 h-4 bg-green-500 border-2 border-black rounded-full"></div>
                                )}
                            </div>
                            <span className="text-[10px] font-bold text-gray-400">@{friend.user}</span>
                        </div>
                    ))}
                    <div className="flex flex-col items-center space-y-2 flex-shrink-0 cursor-pointer">
                        <div className="w-16 h-16 rounded-full bg-gray-900 flex items-center justify-center border-2 border-dashed border-gray-800 text-gray-600 hover:text-gray-400 hover:border-gray-600 transition">
                            <UserPlus size={24} />
                        </div>
                        <span className="text-[10px] font-bold text-gray-500 italic">Add</span>
                    </div>
                </div>

                {/* Empty State / Feed */}
                <div className="space-y-12">
                    <div className="bg-gray-900/20 rounded-[40px] aspect-[9/10] flex flex-col items-center justify-center text-center p-12 border border-gray-900/50">
                        <div className="bg-gray-800/50 p-6 rounded-full mb-6">
                            <Users size={48} className="text-gray-600" />
                        </div>
                        <h2 className="text-xl font-black italic mb-3">Your friends' feed</h2>
                        <p className="text-sm text-gray-500 font-medium max-w-xs leading-relaxed mb-8">When your friends post videos, they will appear here. Start following your friends to see what they are up to!</p>
                        <button className="bg-primary text-black font-black px-10 py-3 rounded-2xl hover:scale-105 active:scale-95 transition">Find Friends</button>
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}
