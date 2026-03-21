import React from 'react';
import AppLayout from '../Components/AppLayout';
import { Head } from '@inertiajs/react';
import { Radio, Users, Heart, Share2, MessageCircle, Gift, X, ChevronRight } from 'lucide-react';
import { motion } from 'framer-motion';

export default function Live() {
    const liveStreams = [
        { id: 1, user: 'dj_mix master', viewers: '1.2k', title: 'Late Night Beats 🎧', image: 'https://images.pexels.com/photos/1763071/pexels-photo-1763071.jpeg?auto=compress&cs=tinysrgb&w=400' },
        { id: 2, user: 'chef_mari', viewers: '850', title: 'Cooking 3-course meal in 15 mins!', image: 'https://images.pexels.com/photos/2284166/pexels-photo-2284166.jpeg?auto=compress&cs=tinysrgb&w=400' },
        { id: 3, user: 'gamer_pro', viewers: '5.4k', title: 'Ranking up to Global Elite 🎮', image: 'https://images.pexels.com/photos/7915234/pexels-photo-7915234.jpeg?auto=compress&cs=tinysrgb&w=400' },
    ];

    return (
        <AppLayout>
            <Head title="LIVE - AmazamaHub" />

            <div className="max-w-6xl mx-auto w-full py-8 px-4 pb-24 md:pb-8">
                <div className="flex items-center space-x-3 mb-8">
                    <div className="bg-primary p-2 rounded-lg animate-pulse">
                        <Radio size={24} className="text-black" />
                    </div>
                    <h1 className="text-2xl font-black italic tracking-tighter">LIVE Center</h1>
                </div>

                {/* Featured Live */}
                <div className="relative aspect-video w-full rounded-3xl overflow-hidden mb-12 group cursor-pointer border border-gray-800">
                    <img
                        src="https://images.pexels.com/photos/257904/pexels-photo-257904.jpeg?auto=compress&cs=tinysrgb&w=1200"
                        className="w-full h-full object-cover transition duration-700 group-hover:scale-105"
                        alt="Live Background"
                    />
                    <div className="absolute inset-0 bg-gradient-to-t from-black/90 via-transparent to-transparent"></div>

                    <div className="absolute top-6 left-6 flex space-x-3">
                        <div className="bg-red-600 px-3 py-1 rounded text-[10px] font-black uppercase tracking-widest flex items-center space-x-1.5">
                            <span className="w-1.5 h-1.5 bg-white rounded-full animate-ping"></span>
                            <span>LIVE</span>
                        </div>
                        <div className="bg-black/50 backdrop-blur-md px-3 py-1 rounded text-[10px] font-black uppercase tracking-widest flex items-center space-x-1.5">
                            <Users size={12} />
                            <span>12,432 Viewers</span>
                        </div>
                    </div>

                    <div className="absolute bottom-8 left-8 right-8 flex items-end justify-between">
                        <div className="space-y-2">
                            <div className="flex items-center space-x-3">
                                <div className="w-12 h-12 rounded-full border-2 border-primary p-0.5">
                                    <img src="https://images.pexels.com/photos/415829/pexels-photo-415829.jpeg?auto=compress&cs=tinysrgb&w=100" className="w-full h-full rounded-full object-cover" />
                                </div>
                                <div>
                                    <p className="font-black italic text-lg tracking-tight">Vibe With Sarah ✨</p>
                                    <p className="text-xs text-gray-300 font-medium">@sarah_vibes</p>
                                </div>
                            </div>
                            <p className="text-sm text-gray-400 font-medium max-w-md">Chatting with you guys and sharing my morning routine! Ask me anything! ☕️</p>
                        </div>
                        <div className="flex space-x-4">
                            <button className="p-3 bg-white/10 backdrop-blur-md rounded-full hover:bg-white/20 transition"><Heart size={20} /></button>
                            <button className="p-3 bg-white/10 backdrop-blur-md rounded-full hover:bg-white/20 transition"><Gift size={20} className="text-yellow-400" /></button>
                            <button className="p-3 bg-primary rounded-full text-black hover:scale-110 transition"><ChevronRight size={24} /></button>
                        </div>
                    </div>
                </div>

                {/* Sub-grid */}
                <h2 className="text-xl font-black italic mb-6 px-2 text-white/80 uppercase tracking-widest text-[12px]">Trending Streams</h2>
                <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
                    {liveStreams.map((stream) => (
                        <motion.div
                            key={stream.id}
                            whileHover={{ y: -5 }}
                            className="bg-gray-900/40 rounded-3xl overflow-hidden border border-gray-800 hover:border-gray-700 transition group"
                        >
                            <div className="relative aspect-[4/5]">
                                <img src={stream.image} className="w-full h-full object-cover group-hover:scale-110 transition duration-700" />
                                <div className="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent"></div>
                                <div className="absolute top-4 left-4 bg-red-600 px-2 py-0.5 rounded text-[8px] font-black uppercase tracking-widest">LIVE</div>
                                <div className="absolute top-4 right-4 bg-black/40 backdrop-blur-sm px-2 py-0.5 rounded text-[8px] font-black flex items-center space-x-1">
                                    <Users size={10} />
                                    <span>{stream.viewers}</span>
                                </div>
                                <div className="absolute bottom-4 left-4 right-4">
                                    <p className="font-black text-sm truncate mb-1">{stream.title}</p>
                                    <p className="text-[10px] text-gray-400 font-medium">@{stream.user}</p>
                                </div>
                            </div>
                        </motion.div>
                    ))}
                </div>
            </div>
        </AppLayout>
    );
}
