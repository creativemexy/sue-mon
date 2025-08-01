"use client"

import Navbar from "@/components/Navbar";
import Footer from "@/components/Footer";
import CartSidebar from "@/components/CartSidebar";
import SearchModal from "@/components/SearchModal";
import Returns from "@/pages/Returns";

export default function ReturnsPage() {
  return (
    <div className="min-h-screen bg-background">
      <Navbar />
      <main>
        <Returns />
      </main>
      <Footer />
      <CartSidebar />
      <SearchModal />
    </div>
  );
} 