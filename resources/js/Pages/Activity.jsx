import React from 'react';
import AppLayout from '../Components/AppLayout';
import { Head } from '@inertiajs/react';
import { Clock, Play, Heart, MessageCircle, ShoppingBag, Trash2, Search, Video } from 'lucide-react';
import { motion } from 'framer-motion';

export default function Activity() {
    const history = [
        { id: 1, type: 'video', title: 'Amazing Parkour in Paris 🏃‍♂️', date: 'Today, 2:43 PM', image: 'https://images.pexels.com/photos/1763071/pexels-photo-1763071.jpeg?auto=compress&cs=tinysrgb&w=300' },
        { id: 2, type: 'shop', title: 'Premium Ring Light V2', date: 'Today, 11:15 AM', image: 'https://images.pexels.com/photos/190819/pexels-photo-190819.jpeg?auto=compress&cs=tinysrgb&w=300' },
        { id: 3, type: 'video', title: 'How to cook the perfect steak 🥩', date: 'Yesterday, 9:20 PM', image: 'https://images.pexels.com/photos/2284166/pexels-photo-2284166.jpeg?auto=compress&cs=tinysrgb&w=300' },
    ];

    return (
        <AppLayout>
            <Head title="Activity Center - AmazamaHub" />
            
            <div className="max-w-4xl mx-auto w-full py-12 px-4 pb-24 md:pb-12">
                <div className="flex items-center justify-between mb-12 px-4">
                    <div className="flex items-center space-x-3">
                         <div className="bg-purple-600/20 p-2 rounded-xl text-purple-400"><Clock size={24}/></div>
                         <h1 className="text-2xl font-black italic tracking-tighter">Your Activity</h1>
                    </div>
                    <button className="text-[10px] font-black italic uppercase text-red-500 hover:underline">Clear All History</button>
                </div>

                {/* Filter Tabs */}
                <div className="flex space-x-4 mb-10 overflow-x-auto noscrollbar pb-2">
                    {['All History', 'Watch History', 'Comment History', 'Search History', 'Shop History'].map((tab, i) => (
                        <button key={i} className={`px-6 py-2 rounded-full text-[10px] font-black uppercase tracking-widest border transition whitespace-nowrap ${i === 0 ? 'bg-white text-black border-white' : 'bg-transparent text-gray-500 border-gray-800 hover:border-gray-600'}`}>
                            {tab}
                        </button>
                    ))}
                </div>

                {/* Activity List */}
                <div className="space-y-4">
                    {history.map((item) => (
                        <div key={item.id} className="bg-gray-900/10 border border-gray-900 p-6 rounded-[32px] flex items-center space-x-6 hover:bg-gray-900/40 transition group relative overflow-hidden">
                             <div className="w-20 h-20 rounded-2xl overflow-hidden bg-black flex-shrink-0 relative group-hover:scale-95 transition">
                                 <img src={item.image} className="w-full h-full object-cover" />
                                 <div className="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition">
                                     {item.type === 'video' ? <Video size={20}/> : <ShoppingBag size={20}/>}
                                 </div>
                             </div>
                             <div className="flex-1 min-w-0">
                                 <div className="flex items-center space-x-2 text-[8px] font-black uppercase tracking-tighter text-purple-400 mb-1">
                                     {item.type === 'video' ? <Play size={10}/> : <ShoppingBag size={10}/>}
                                     <span>{item.type} history</span>
                                 </div>
                                 <h3 className="font-bold text-gray-200 truncate pr-12">{item.title}</h3>
                                 <p className="text-[10px] text-gray-500 font-medium mt-1">{item.date}</p>
                             </div>
                             <button className="absolute right-8 top-1/2 -translate-y-1/2 p-2 text-gray-800 hover:text-red-500 transition opacity-0 group-hover:opacity-100"><Trash2 size={18}/></button>
                        </div>
                    ))}
                </div>

                <div className="mt-20 p-10 bg-gradient-to-br from-gray-900 to-transparent border border-gray-900 rounded-[40px] text-center">
                    <History size={48} className="mx-auto text-gray-800 mb-4 opacity-20" />
                    <p className="text-xs text-gray-600 font-medium max-w-sm mx-auto">AmazamaHub stores your activity to provide more accurate content recommendations. Your history is never shared with other users.</p>
                </div>
            </div>
        </AppLayout>
    );
}

import { History } from 'lucide-react';
