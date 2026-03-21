import React from 'react';
import AppLayout from '../Components/AppLayout';
import { Head } from '@inertiajs/react';
import { Search as SearchIcon, Users, Play, Hash, ChevronRight, X } from 'lucide-react';
import { motion } from 'framer-motion';

export default function Search() {
    const results = [
        { type: 'user', name: 'James Viral', username: 'james_pro', followers: '1.2M', avatar: 'https://images.pexels.com/photos/220453/pexels-photo-220453.jpeg?auto=compress&cs=tinysrgb&w=100' },
        { type: 'hashtag', name: 'programming', views: '4.5B' },
        { type: 'video', user: 'coding_daily', title: 'React Hooks Explained! 👨‍💻', views: '234k', image: 'https://images.pexels.com/photos/1103533/pexels-photo-1103533.jpeg?auto=compress&cs=tinysrgb&w=300' },
    ];

    return (
        <AppLayout>
            <Head title="Search - AmazamaHub" />

            <div className="max-w-4xl mx-auto w-full py-8 px-4 pb-24 md:pb-8">
                {/* Search Header */}
                <div className="flex items-center space-x-4 mb-10">
                    <div className="flex-1 relative group">
                        <SearchIcon className="absolute left-5 top-1/2 -translate-y-1/2 text-gray-500 group-focus-within:text-primary transition" size={18} />
                        <input
                            type="text"
                            defaultValue="programming"
                            className="w-full bg-gray-900/60 border border-gray-800 rounded-full py-3.5 px-12 text-sm font-semibold focus:outline-none focus:border-primary transition"
                        />
                        <button className="absolute right-5 top-1/2 -translate-y-1/2 text-gray-600 hover:text-white"><X size={18} /></button>
                    </div>
                    <button className="text-primary font-black italic px-4">Cancel</button>
                </div>

                {/* Tabs */}
                <div className="flex space-x-8 border-b border-gray-900 mb-8 px-2 overflow-x-auto noscrollbar">
                    {['Top', 'Users', 'Videos', 'Sounds', 'LIVE', 'Hashtags'].map((tab, i) => (
                        <button key={i} className={`pb-4 text-sm font-black italic tracking-widest relative ${i === 0 ? 'text-white' : 'text-gray-500'}`}>
                            {tab}
                            {i === 0 && <div className="absolute bottom-0 left-0 right-0 h-1 bg-white rounded-full"></div>}
                        </button>
                    ))}
                </div>

                {/* Results Section */}
                <div className="space-y-6">
                    {/* Related Hasthags */}
                    <div className="flex space-x-3 overflow-x-auto pb-4 noscrollbar">
                        {['coding', 'tech', 'javascript', 'react', 'webdev'].map((tag, i) => (
                            <div key={i} className="bg-gray-900/40 border border-gray-800 px-4 py-2 rounded-xl flex items-center space-x-2 flex-shrink-0 cursor-pointer hover:border-gray-600 transition">
                                <Hash size={14} className="text-gray-500" />
                                <span className="text-xs font-bold">{tag}</span>
                            </div>
                        ))}
                    </div>

                    <div className="space-y-2">
                        {results.map((res, i) => (
                            <div key={i} className="bg-gray-900/20 border border-transparent hover:border-gray-800 rounded-3xl p-4 flex items-center justify-between group cursor-pointer transition">
                                <div className="flex items-center space-x-4">
                                    {res.type === 'user' ? (
                                        <div className="w-14 h-14 rounded-full overflow-hidden border border-gray-800">
                                            <img src={res.avatar} className="w-full h-full object-cover" />
                                        </div>
                                    ) : res.type === 'hashtag' ? (
                                        <div className="w-14 h-14 rounded-full bg-gray-800 flex items-center justify-center">
                                            <Hash size={24} className="text-gray-400" />
                                        </div>
                                    ) : (
                                        <div className="w-14 h-14 rounded-2xl overflow-hidden relative">
                                            <img src={res.image} className="w-full h-full object-cover" />
                                            <div className="absolute inset-0 bg-black/20 flex items-center justify-center"><Play size={16} fill="white" /></div>
                                        </div>
                                    )}

                                    <div>
                                        <p className="font-black italic text-sm">{res.name}</p>
                                        <p className="text-[10px] text-gray-500 font-bold uppercase tracking-widest">
                                            {res.type === 'user' ? `@${res.username} • ${res.followers} followers` :
                                                res.type === 'hashtag' ? `${res.views} views` :
                                                    `@${res.user} • ${res.views} views`}
                                        </p>
                                    </div>
                                </div>
                                <ChevronRight size={20} className="text-gray-800 group-hover:text-primary transition" />
                            </div>
                        ))}
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}
