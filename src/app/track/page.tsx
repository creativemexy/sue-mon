"use client"

import Navbar from "@/components/Navbar";
import Footer from "@/components/Footer";
import CartSidebar from "@/components/CartSidebar";
import SearchModal from "@/components/SearchModal";
import Track from "@/pages/Track";

export default function TrackPage() {
  return (
    <div className="min-h-screen bg-background">
      <Navbar />
      <main>
        <Track />
      </main>
      <Footer />
      <CartSidebar />
      <SearchModal />
    </div>
  );
} 