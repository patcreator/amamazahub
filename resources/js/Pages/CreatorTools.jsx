import React from 'react';
import AppLayout from '../Components/AppLayout';
import { Head } from '@inertiajs/react';
import { BarChart3, Users, Zap, Play, LayoutDashboard, MessageCircle, Star, Target, BookOpen } from 'lucide-react';
import { motion } from 'framer-motion';

export default function CreatorTools() {
    const stats = [
        { label: 'Followers', value: '1,243', change: '+12%', icon: <Users size={20} className="text-blue-400" /> },
        { label: 'Video Views', value: '45.2k', change: '+8%', icon: <Play size={20} className="text-primary" /> },
        { label: 'Profile Views', value: '890', change: '+24%', icon: <BarChart3 size={20} className="text-purple-400" /> },
        { label: 'Likes', value: '12.8k', change: '+5%', icon: <Star size={20} className="text-yellow-400" /> },
    ];

    return (
        <AppLayout>
            <Head title="Creator Tools - AmazamaHub" />

            <div className="max-w-5xl mx-auto w-full py-8 px-4 pb-24 md:pb-8">
                <div className="flex items-center space-x-3 mb-8">
                    <div className="bg-primary/10 p-2 rounded-xl border border-primary/20">
                        <Zap size={24} className="text-primary" />
                    </div>
                    <h1 className="text-2xl font-black italic tracking-tighter">Creator Tools</h1>
                </div>

                {/* Dashboard Stats */}
                <div className="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-10">
                    {stats.map((stat, i) => (
                        <div key={i} className="bg-gray-900/30 border border-gray-800 p-6 rounded-3xl space-y-3">
                            <div className="flex items-center justify-between">
                                {stat.icon}
                                <span className="text-[10px] font-black text-green-400 bg-green-400/10 px-2 py-0.5 rounded-full">{stat.change}</span>
                            </div>
                            <div>
                                <p className="text-xl font-black italic">{stat.value}</p>
                                <p className="text-[10px] text-gray-500 font-bold uppercase tracking-wider">{stat.label}</p>
                            </div>
                        </div>
                    ))}
                </div>

                <div className="grid grid-cols-1 md:grid-cols-2 gap-8">
                    {/* Activity Section */}
                    <div className="space-y-6">
                        <h2 className="text-sm font-black uppercase tracking-widest text-gray-400 px-2">Main Features</h2>
                        <div className="space-y-4">
                            {[
                                { title: 'Analytics', desc: 'Detailed insights on your growth', icon: <BarChart3 className="text-primary" /> },
                                { title: 'Creator Portal', desc: 'Learn how to grow your brand', icon: <BookOpen className="text-blue-400" /> },
                                { title: 'Monetization', desc: 'Earnings, rewards, and diamonds', icon: <Target className="text-green-400" /> },
                            ].map((item, i) => (
                                <div key={i} className="flex items-center space-x-4 p-5 bg-gray-900/20 border border-gray-900 rounded-3xl cursor-pointer hover:border-gray-700 transition">
                                    <div className="bg-gray-800 p-3 rounded-2xl">{item.icon}</div>
                                    <div>
                                        <p className="font-black italic text-sm">{item.title}</p>
                                        <p className="text-xs text-gray-500 font-medium">{item.desc}</p>
                                    </div>
                                </div>
                            ))}
                        </div>
                    </div>

                    {/* Promotions Section */}
                    <div className="bg-gradient-to-br from-primary/20 to-purple-500/10 p-8 rounded-3xl border border-primary/10 relative overflow-hidden flex flex-col justify-between">
                        <div className="relative z-10">
                            <h3 className="text-2xl font-black italic mb-2">Promote Your Content</h3>
                            <p className="text-sm text-gray-400 font-medium mb-6 leading-relaxed">Boost your videos to reach more viewers. Target specific audiences and grow your community faster than ever.</p>
                            <button className="bg-primary text-black font-black px-8 py-3 rounded-2xl text-sm hover:scale-105 active:scale-95 transition shadow-xl shadow-primary/20">Get Started</button>
                        </div>
                        <div className="absolute top-0 right-0 p-8">
                            <Zap size={80} className="text-primary/5 -rotate-12" />
                        </div>
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}
